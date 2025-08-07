<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Equipment extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Temporarily disable auth for testing
        // $this->_check_auth();

        $this->load->model('emergency_tools/Equipment_model');
        $this->load->model('emergency_tools/Equipment_type_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
        $this->load->database();
    }

    /**
     * Halaman equipment management
     */
    public function index()
    {
        $data['title'] = 'Equipment Management';
        $data['user'] = $this->session->userdata();

        $this->load->view('emergency_tools/templates/header', $data);
        $this->load->view('emergency_tools/templates/sidebar', $data);
        $this->load->view('emergency_tools/equipment/index', $data);
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
                    $result = $this->Equipment_model->get_equipment($id);
                    if ($result) {
                        echo json_encode(['success' => true, 'data' => $result]);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Equipment tidak ditemukan']);
                    }
                } else {
                    $result = $this->Equipment_model->get_all_equipment();
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
                    $result = $this->Equipment_model->delete_equipment($id);
                    if ($result) {
                        echo json_encode(['success' => true, 'message' => 'Equipment berhasil dihapus']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Gagal menghapus equipment']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'ID diperlukan untuk delete']);
                }
                break;

            case 'get_locations':
                $this->load->model('emergency_tools/Location_model');
                $locations = $this->Location_model->get_locations_for_dropdown();
                echo json_encode(['success' => true, 'data' => $locations]);
                break;

            case 'get_equipment_types':
                $types = $this->Equipment_type_model->get_active_equipment_types_for_dropdown();
                echo json_encode(['success' => true, 'data' => $types]);
                break;

            case 'generate_qrcode':
                $this->_handle_generate_qrcode();
                break;

            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
                break;
        }
    }

    /**
     * Handle create equipment
     */
    private function _handle_create()
    {
        $equipment_code = $this->input->post('equipment_code');
        $location_id = $this->input->post('location_id');
        $equipment_type_id = $this->input->post('equipment_type_id');
        $status = $this->input->post('status') ?: 'active';

        // Validation
        if (empty($equipment_code) || empty($location_id) || empty($equipment_type_id)) {
            echo json_encode(['success' => false, 'message' => 'Equipment code, location, dan equipment type harus diisi']);
            return;
        }

        // Check if equipment code already exists
        $this->db->where('equipment_code', $equipment_code);
        $existing = $this->db->get('tm_equipments')->row();
        if ($existing) {
            echo json_encode(['success' => false, 'message' => 'Equipment code sudah ada']);
            return;
        }

        // Generate and save QR code image, store path in qrcode field
        $qr_image_path = $this->_generateQRCodeImage($equipment_code);
        if (!$qr_image_path) {
            echo json_encode(['success' => false, 'message' => 'Gagal membuat QR Code image']);
            return;
        }

        $data = [
            'equipment_code' => $equipment_code,
            'location_id' => $location_id,
            'equipment_type_id' => $equipment_type_id,
            'qrcode' => $qr_image_path, // Store QR image path in qrcode field
            'status' => $status
        ];

        $result = $this->Equipment_model->insert_equipment($data);
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Equipment berhasil ditambahkan',
                'qr_image_url' => base_url($qr_image_path)
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menambahkan equipment']);
        }
    }

    /**
     * Handle update equipment
     */
    private function _handle_update()
    {
        $id = $this->input->post('id');

        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'ID diperlukan untuk update']);
            return;
        }

        // Debug log for checking what's received
        log_message('debug', 'Update request - ID: ' . $id);
        log_message('debug', 'POST data: ' . print_r($this->input->post(), true));

        // Get existing equipment data to preserve unchanged fields
        $existing_equipment = $this->Equipment_model->get_equipment($id);
        if (!$existing_equipment) {
            echo json_encode(['success' => false, 'message' => 'Equipment tidak ditemukan']);
            return;
        }

        // Get input data, only update fields that are provided and different
        $data = [];
        $has_changes = false;

        // Check equipment_code
        $new_equipment_code = trim($this->input->post('equipment_code'));
        if (!empty($new_equipment_code) && $new_equipment_code !== $existing_equipment->equipment_code) {
            // Check if equipment code already exists
            $this->db->where('equipment_code', $new_equipment_code);
            $this->db->where('id !=', $id);
            $duplicate = $this->db->get('tm_equipments')->row();
            if ($duplicate) {
                echo json_encode(['success' => false, 'message' => 'Equipment code sudah ada']);
                return;
            }
            $data['equipment_code'] = $new_equipment_code;
            $has_changes = true;
        }

        // Check location_id
        $new_location_id = $this->input->post('location_id');
        if (!empty($new_location_id) && $new_location_id != $existing_equipment->location_id) {
            $data['location_id'] = $new_location_id;
            $has_changes = true;
        }

        // Check equipment_type_id
        $new_equipment_type_id = $this->input->post('equipment_type_id');
        if (!empty($new_equipment_type_id) && $new_equipment_type_id != $existing_equipment->equipment_type_id) {
            $data['equipment_type_id'] = $new_equipment_type_id;
            $has_changes = true;
        }

        // Check status
        $new_status = $this->input->post('status');
        if (!empty($new_status) && $new_status !== $existing_equipment->status) {
            $data['status'] = $new_status;
            $has_changes = true;
        }

        // Validate required fields (use existing if not provided)
        $final_equipment_code = $new_equipment_code ?: $existing_equipment->equipment_code;
        $final_location_id = $new_location_id ?: $existing_equipment->location_id;
        $final_equipment_type_id = $new_equipment_type_id ?: $existing_equipment->equipment_type_id;

        if (empty($final_equipment_code) || empty($final_location_id) || empty($final_equipment_type_id)) {
            echo json_encode(['success' => false, 'message' => 'Equipment code, location, dan equipment type harus diisi']);
            return;
        }

        // If no changes, return success without updating
        if (!$has_changes) {
            echo json_encode(['success' => true, 'message' => 'Tidak ada perubahan data']);
            return;
        }

        // Add updated timestamp only if there are changes  
        $data['update_at'] = date('Y-m-d H:i:s');

        $result = $this->Equipment_model->update_equipment($id, $data);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Equipment berhasil diupdate']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengupdate equipment']);
        }
    }

    /**
     * Handle generate QR code (now returns only text, no API calls)
     */
    private function _handle_generate_qrcode()
    {
        $equipment_code = $this->input->post('equipment_code');

        // Validation
        if (empty($equipment_code)) {
            echo json_encode(['success' => false, 'message' => 'Equipment code harus diisi untuk generate QR code']);
            return;
        }

        // Generate QR Code text berdasarkan equipment code
        $qr_text = $equipment_code; // Simplified - just use equipment code directly

        try {
            echo json_encode([
                'success' => true,
                'message' => 'QR Code text berhasil di-generate',
                'data' => [
                    'equipment_code' => $equipment_code,
                    'qrcode_text' => $qr_text
                ]
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Gagal generate QR Code: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Generate QR code text dari equipment code (simplified)
     */
    private function _generate_qrcode_text_from_equipment_code($equipment_code)
    {
        return $equipment_code; // Simplified - just return equipment code
    }

    /**
     * Generate QR Code image and save to assets/emergency_tools/img/qrcode/
     */
    private function _generateQRCodeImage($equipment_code)
    {
        try {
            // Create directory if not exists
            $qr_dir = FCPATH . 'assets/emergency_tools/img/qrcode/';
            if (!is_dir($qr_dir)) {
                mkdir($qr_dir, 0755, true);
            }

            // Generate filename
            $filename = 'qr_' . strtolower(str_replace(['-', ' ', '/'], '_', $equipment_code)) . '_' . time() . '.png';
            $filepath = $qr_dir . $filename;
            $relative_path = 'assets/emergency_tools/img/qrcode/' . $filename;

            // Use QR-Server API instead of Google Charts
            $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($equipment_code);

            // Download and save the image
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'timeout' => 30,
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                ]
            ]);

            $image_data = file_get_contents($qr_url, false, $context);

            if ($image_data === false) {
                return false;
            }

            $result = file_put_contents($filepath, $image_data);

            if ($result === false) {
                return false;
            }

            return $relative_path;

        } catch (Exception $e) {
            log_message('error', 'QR Code generation failed: ' . $e->getMessage());
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
