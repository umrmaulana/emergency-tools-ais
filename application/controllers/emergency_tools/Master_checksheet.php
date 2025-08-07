<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_checksheet extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Temporarily disable auth for testing
        // $this->_check_auth();

        // Load models and libraries
        $this->load->model('emergency_tools/Checksheet_template_model');
        $this->load->model('emergency_tools/Equipment_type_model');
        $this->load->library(['session', 'upload', 'form_validation']);
        $this->load->helper(['url', 'file']);
    }

    /**
     * Halaman master checksheet
     */
    public function index()
    {
        $data['title'] = 'Master Checksheet Templates';
        $data['user'] = $this->session->userdata();

        // Get equipment types with template counts
        $data['equipment_types'] = $this->Checksheet_template_model->count_templates_by_equipment_type();

        // Get all templates grouped by equipment type
        $data['templates_grouped'] = $this->Checksheet_template_model->get_templates_grouped();

        // Get active equipment types for dropdown
        $data['equipment_types_dropdown'] = $this->Equipment_type_model->get_active_equipment_types_for_dropdown();

        $this->load->view('emergency_tools/templates/header', $data);
        $this->load->view('emergency_tools/templates/sidebar', $data);
        $this->load->view('emergency_tools/master_checksheet/index', $data);
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
                    $result = $this->Checksheet_template_model->get_template_by_id($id);
                    echo json_encode(['success' => true, 'data' => $result]);
                } else {
                    $equipment_type_id = $this->input->get('equipment_type_id');
                    $result = $this->Checksheet_template_model->get_all_templates($equipment_type_id);
                    echo json_encode(['success' => true, 'data' => $result]);
                }
                break;

            case 'get_grouped':
                $result = $this->Checksheet_template_model->get_templates_grouped();
                echo json_encode(['success' => true, 'data' => $result]);
                break;

            case 'get_by_type':
                if ($id) {
                    $result = $this->Checksheet_template_model->get_templates_by_equipment_type($id);
                    echo json_encode(['success' => true, 'data' => $result]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Equipment type ID diperlukan']);
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
                    $result = $this->Checksheet_template_model->delete_template($id);
                    echo json_encode($result);
                } else {
                    echo json_encode(['success' => false, 'message' => 'ID diperlukan untuk delete']);
                }
                break;

            case 'reorder':
                $this->_handle_reorder();
                break;

            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
                break;
        }
    }

    /**
     * Handle create template
     */
    private function _handle_create()
    {
        $equipment_type_id = $this->input->post('equipment_type_id');
        $order_number = $this->input->post('order_number');
        $item_name = $this->input->post('item_name');
        $standar_condition = $this->input->post('standar_condition');
        $standar_picture_url = $this->input->post('standar_picture_url');

        // Debug: Log received data
        error_log('Create template data: ' . print_r($_POST, true));
        error_log('Files data: ' . print_r($_FILES, true));

        // Validation
        if (empty($equipment_type_id) || empty($item_name) || empty($standar_condition)) {
            echo json_encode(['success' => false, 'message' => 'Equipment type, item name, dan standard condition harus diisi']);
            return;
        }

        // Auto-generate order number if not provided
        if (empty($order_number)) {
            $order_number = $this->Checksheet_template_model->get_next_order_number($equipment_type_id);
        }

        // Handle file upload for standard picture
        $picture_filename = $this->_handle_picture_upload();
        error_log('Picture upload result: ' . ($picture_filename ? $picture_filename : 'FAILED'));

        if ($picture_filename !== false) {
            $standar_picture_url = $picture_filename;
        }

        $data = [
            'equipment_type_id' => $equipment_type_id,
            'order_number' => $order_number,
            'item_name' => $item_name,
            'standar_condition' => $standar_condition,
            'standar_picture_url' => $standar_picture_url,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Debug: Log data to be inserted
        error_log('Template data to insert: ' . print_r($data, true));

        $result = $this->Checksheet_template_model->create_template($data);

        // Debug: Log result
        error_log('Insert template result: ' . ($result ? 'SUCCESS' : 'FAILED'));

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Template checksheet berhasil ditambahkan']);
        } else {
            // Get database error
            $db_error = $this->db->error();
            error_log('Database error: ' . print_r($db_error, true));
            echo json_encode(['success' => false, 'message' => 'Gagal menambahkan template: ' . $db_error['message']]);
        }
    }

    /**
     * Handle update template
     */
    private function _handle_update()
    {
        $id = $this->input->post('id');
        $equipment_type_id = $this->input->post('equipment_type_id');
        $order_number = $this->input->post('order_number');
        $item_name = $this->input->post('item_name');
        $standar_condition = $this->input->post('standar_condition');
        $standar_picture_url = $this->input->post('standar_picture_url');

        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'ID diperlukan untuk update']);
            return;
        }

        // Validation
        if (empty($equipment_type_id) || empty($item_name) || empty($standar_condition)) {
            echo json_encode(['success' => false, 'message' => 'Equipment type, item name, dan standard condition harus diisi']);
            return;
        }

        // Get existing data for picture preservation
        $existing = $this->Checksheet_template_model->get_template_by_id($id);
        if (!$existing) {
            echo json_encode(['success' => false, 'message' => 'Template tidak ditemukan']);
            return;
        }

        // Handle file upload for standard picture
        $picture_filename = $this->_handle_picture_upload();
        if ($picture_filename !== false) {
            $standar_picture_url = $picture_filename;
            // Delete old picture if exists and different
            if ($existing->standar_picture_url && $existing->standar_picture_url !== $picture_filename) {
                $old_path = FCPATH . 'assets/emergency_tools/img/standards/' . $existing->standar_picture_url;
                if (file_exists($old_path)) {
                    unlink($old_path);
                }
            }
        } else {
            // Preserve existing picture if no new upload
            $standar_picture_url = $standar_picture_url ?: $existing->standar_picture_url;
        }

        $data = [
            'equipment_type_id' => $equipment_type_id,
            'order_number' => $order_number,
            'item_name' => $item_name,
            'standar_condition' => $standar_condition,
            'standar_picture_url' => $standar_picture_url,
            'update_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->Checksheet_template_model->update_template($id, $data);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Template berhasil diupdate']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengupdate template']);
        }
    }

    /**
     * Handle reorder templates
     */
    private function _handle_reorder()
    {
        $equipment_type_id = $this->input->post('equipment_type_id');
        $template_orders = $this->input->post('template_orders');

        if (empty($equipment_type_id) || empty($template_orders)) {
            echo json_encode(['success' => false, 'message' => 'Equipment type ID dan template orders diperlukan']);
            return;
        }

        $result = $this->Checksheet_template_model->reorder_templates($equipment_type_id, $template_orders);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Template berhasil diurutkan ulang']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengurutkan ulang template']);
        }
    }

    /**
     * Handle standard picture upload
     */
    private function _handle_picture_upload()
    {
        if (!isset($_FILES['standard_picture']) || $_FILES['standard_picture']['error'] === UPLOAD_ERR_NO_FILE) {
            return false;
        }

        // Check for upload errors
        if ($_FILES['standard_picture']['error'] !== UPLOAD_ERR_OK) {
            error_log('Upload error code: ' . $_FILES['standard_picture']['error']);
            return false;
        }

        $upload_path = FCPATH . 'assets/emergency_tools/img/standards/';

        // Ensure directory exists with proper permissions
        if (!is_dir($upload_path)) {
            if (!mkdir($upload_path, 0755, true)) {
                error_log('Failed to create upload directory: ' . $upload_path);
                return false;
            }
        }

        // Make sure directory is writable
        if (!is_writable($upload_path)) {
            chmod($upload_path, 0755);
        }

        // Validate file type
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $file_type = $_FILES['standard_picture']['type'];
        if (!in_array($file_type, $allowed_types)) {
            error_log('Invalid file type: ' . $file_type);
            return false;
        }

        // Validate file size (2MB max)
        if ($_FILES['standard_picture']['size'] > 2097152) {
            error_log('File too large: ' . $_FILES['standard_picture']['size']);
            return false;
        }

        // Debug: Log the upload path and file info
        error_log('Upload path: ' . $upload_path);
        error_log('Upload path exists: ' . (is_dir($upload_path) ? 'YES' : 'NO'));
        error_log('Upload path writable: ' . (is_writable($upload_path) ? 'YES' : 'NO'));
        error_log('File info: ' . print_r($_FILES['standard_picture'], true));

        // Generate unique filename
        $file_extension = pathinfo($_FILES['standard_picture']['name'], PATHINFO_EXTENSION);
        $new_filename = 'standard_' . time() . '_' . rand(1000, 9999) . '.' . $file_extension;
        $full_path = $upload_path . $new_filename;

        // Manual upload handling
        if (move_uploaded_file($_FILES['standard_picture']['tmp_name'], $full_path)) {
            error_log('File uploaded successfully: ' . $new_filename);
            return $new_filename;
        } else {
            error_log('Failed to move uploaded file to: ' . $full_path);
            error_log('Upload error code: ' . $_FILES['standard_picture']['error']);
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
