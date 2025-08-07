<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_equipment extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Temporarily disable auth for testing
        // $this->_check_auth();
        $this->load->model('emergency_tools/Equipment_type_model');
    }

    /**
     * Halaman master equipment
     */
    public function index()
    {
        $data['title'] = 'Master Equipment Types';
        $data['user'] = $this->session->userdata();

        // Get all equipment types for display
        $data['equipment_types'] = $this->Equipment_type_model->get_all_equipment_types();

        $this->load->view('emergency_tools/templates/header', $data);
        $this->load->view('emergency_tools/templates/sidebar', $data);
        $this->load->view('emergency_tools/master_equipment/index', $data);
        $this->load->view('emergency_tools/templates/footer', $data);
    }

    /**
     * API endpoints
     */
    public function api($action = null, $id = null)
    {
        header('Content-Type: application/json');

        switch ($action) {
            case 'get':
                if ($id) {
                    $result = $this->Equipment_type_model->get_equipment_type_by_id($id);
                    echo json_encode(['success' => true, 'data' => $result]);
                } else {
                    $result = $this->Equipment_type_model->get_all_equipment_types();
                    echo json_encode(['success' => true, 'data' => $result]);
                }
                break;

            case 'create':
                $this->_handle_create();
                break;

            case 'update':
                $this->_handle_update();
                break;

            case 'delete':
                if ($id) {
                    $result = $this->Equipment_type_model->delete_equipment_type($id);
                    echo json_encode($result);
                } else {
                    echo json_encode(['success' => false, 'message' => 'ID diperlukan untuk delete']);
                }
                break;

            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
                break;
        }
    }

    /**
     * Handle create equipment type
     */
    private function _handle_create()
    {
        $equipment_name = $this->input->post('equipment_name');
        $equipment_type = $this->input->post('equipment_type');
        $description = $this->input->post('desc');
        $icon_url = $this->input->post('icon_url');
        $is_active = $this->input->post('is_active');

        // Debug: Log received data
        error_log('Create request data: ' . print_r($_POST, true));
        error_log('Files data: ' . print_r($_FILES, true));

        // Validation
        if (empty($equipment_name) || empty($equipment_type)) {
            echo json_encode(['success' => false, 'message' => 'Equipment name dan type harus diisi']);
            return;
        }

        // Check if equipment type already exists
        if ($this->Equipment_type_model->equipment_type_exists($equipment_type)) {
            echo json_encode(['success' => false, 'message' => 'Equipment type sudah ada']);
            return;
        }

        // Handle file upload if icon is uploaded
        $icon_filename = $this->_handle_icon_upload();
        if ($icon_filename !== false) {
            $icon_url = $icon_filename;
        }

        $data = [
            'equipment_name' => $equipment_name,
            'equipment_type' => strtoupper($equipment_type),
            'desc' => $description,
            'icon_url' => $icon_url,
            'is_active' => $is_active ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Debug: Log data to be inserted
        error_log('Data to insert: ' . print_r($data, true));

        $result = $this->Equipment_type_model->create_equipment_type($data);

        // Debug: Log result
        error_log('Insert result: ' . ($result ? 'SUCCESS' : 'FAILED'));

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Equipment type berhasil ditambahkan']);
        } else {
            // Get database error
            $db_error = $this->db->error();
            error_log('Database error: ' . print_r($db_error, true));
            echo json_encode(['success' => false, 'message' => 'Gagal menambahkan equipment type: ' . $db_error['message']]);
        }
    }

    /**
     * Handle update equipment type
     */
    private function _handle_update()
    {
        $id = $this->input->post('id');
        $equipment_name = $this->input->post('equipment_name');
        $equipment_type = $this->input->post('equipment_type');
        $description = $this->input->post('desc');
        $icon_url = $this->input->post('icon_url');
        $is_active = $this->input->post('is_active');

        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'ID diperlukan untuk update']);
            return;
        }

        // Validation
        if (empty($equipment_name) || empty($equipment_type)) {
            echo json_encode(['success' => false, 'message' => 'Equipment name dan type harus diisi']);
            return;
        }

        // Check if equipment type already exists (exclude current ID)
        if ($this->Equipment_type_model->equipment_type_exists($equipment_type, $id)) {
            echo json_encode(['success' => false, 'message' => 'Equipment type sudah ada']);
            return;
        }

        // Get existing data for icon preservation
        $existing = $this->Equipment_type_model->get_equipment_type_by_id($id);
        if (!$existing) {
            echo json_encode(['success' => false, 'message' => 'Equipment type tidak ditemukan']);
            return;
        }

        // Handle file upload if icon is uploaded
        $icon_filename = $this->_handle_icon_upload();
        if ($icon_filename !== false) {
            $icon_url = $icon_filename;
            // Delete old icon if exists and different
            if ($existing->icon_url && $existing->icon_url !== $icon_url) {
                $old_path = FCPATH . 'assets/emergency_tools/img/equipment/' . $existing->icon_url;
                if (file_exists($old_path)) {
                    unlink($old_path);
                }
            }
        } else {
            // Preserve existing icon if no new upload
            $icon_url = $icon_url ?: $existing->icon_url;
        }

        $data = [
            'equipment_name' => $equipment_name,
            'equipment_type' => strtoupper($equipment_type),
            'desc' => $description,
            'icon_url' => $icon_url,
            'is_active' => $is_active ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->Equipment_type_model->update_equipment_type($id, $data);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Equipment type berhasil diupdate']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengupdate equipment type']);
        }
    }

    /**
     * Handle icon upload
     */
    private function _handle_icon_upload()
    {
        if (!isset($_FILES['icon_file']) || $_FILES['icon_file']['error'] === UPLOAD_ERR_NO_FILE) {
            return false;
        }

        $upload_path = FCPATH . 'assets/emergency_tools/img/equipment/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|svg|webp';
        $config['max_size'] = 2048; // 2MB
        $config['file_name'] = 'equipment_' . time() . '_' . rand(1000, 9999);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('icon_file')) {
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        } else {
            error_log('Upload error: ' . $this->upload->display_errors());
            return false;
        }
    }

    /**
     * Cek apakah user sudah login dan merupakan supervisor
     */
    private function _check_auth()
    {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('level') !== 'spv') {
            redirect('auth');
        }
    }
}
