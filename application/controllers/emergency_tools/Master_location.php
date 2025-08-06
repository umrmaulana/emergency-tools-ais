<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_location extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Temporarily disable auth for testing
        // $this->_check_auth();
        $this->load->model('Location_model');
    }

    /**
     * Halaman master location
     */
    public function index()
    {
        $data['title'] = 'Master Location';
        $data['user'] = $this->session->userdata();

        // Get all locations for display
        $data['locations'] = $this->Location_model->get_all_locations();

        $this->load->view('emergency_tools/templates/header', $data);
        $this->load->view('emergency_tools/templates/sidebar', $data);
        $this->load->view('emergency_tools/master_location/index', $data);
        $this->load->view('emergency_tools/templates/footer', $data);
    }

    /**
     * Show create form page
     */
    public function create()
    {
        $data['title'] = 'Tambah Lokasi - Master Location';
        // $data['user'] = $this->session->userdata(); // Commented for testing

        $this->load->view('emergency_tools/master_location/create', $data);
    }

    /**
     * Show edit form page
     */
    public function edit_page($id = null)
    {
        if (!$id) {
            show_404();
            return;
        }

        // Get location data
        $location = $this->Location_model->get_location_by_id($id);
        if (!$location) {
            show_404();
            return;
        }

        $data['title'] = 'Edit Lokasi - Master Location';
        $data['location'] = $location;
        // $data['user'] = $this->session->userdata(); // Commented for testing

        $this->load->view('emergency_tools/master_location/edit', $data);
    }

    /**
     * Show edit form page (existing method)
     */
    public function edit($id = null)
    {
        if (!$id) {
            show_404();
            return;
        }

        // Get location data
        $location = $this->Location_model->get_location_by_id($id);
        if (!$location) {
            show_404();
            return;
        }

        $data['title'] = 'Edit Lokasi - Master Location';
        // $data['user'] = $this->session->userdata(); // Commented for testing
        $data['location'] = $location;

        $this->load->view('emergency_tools/master_location/edit', $data);
    }

    /**
     * Get location by ID
     */
    public function get($id = null)
    {
        if ($id) {
            // Get specific location
            $location = $this->Location_model->get_location_by_id($id);

            if ($location) {
                $response = array(
                    'status' => 'success',
                    'data' => $location
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Lokasi tidak ditemukan!'
                );
            }
        } else {
            // Get all locations
            $locations = $this->Location_model->get_all_locations();
            $response = array(
                'status' => 'success',
                'data' => $locations
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    /**
     * Delete location
     */
    public function delete($id)
    {
        if ($this->input->method() !== 'post') {
            show_404();
            return;
        }

        if ($this->Location_model->delete_location($id)) {
            $response = array(
                'status' => 'success',
                'message' => 'Lokasi berhasil dihapus!'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Gagal menghapus data lokasi!'
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    /**
     * API endpoints (compatible with Test_location)
     */
    public function api($action = null, $id = null)
    {
        header('Content-Type: application/json');

        switch ($action) {
            case 'get':
                if ($id) {
                    $result = $this->Location_model->get_location_by_id($id);
                    if ($result) {
                        echo json_encode(['success' => true, 'data' => $result]);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Lokasi tidak ditemukan']);
                    }
                } else {
                    $result = $this->Location_model->get_all_locations();
                    echo json_encode(['success' => true, 'data' => $result]);
                }
                break;

            case 'create':
                $data = array(
                    'location_code' => $this->input->post('location_code'),
                    'location_name' => $this->input->post('location_name'),
                    'desc' => $this->input->post('description'),
                    'area_x' => $this->input->post('area_x'),
                    'area_y' => $this->input->post('area_y'),
                    'area_code' => $this->input->post('area_code'),
                    'created_at' => date('Y-m-d H:i:s')
                );

                // Kode lokasi boleh sama, jadi tidak perlu validasi unique
                $result = $this->Location_model->create_location($data);
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Lokasi berhasil ditambahkan']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Gagal menambahkan lokasi']);
                }
                break;

            case 'update':
                // Debug: Log all POST data
                error_log('POST data: ' . print_r($_POST, true));

                // Ambil ID dari POST data, bukan dari parameter URL
                $update_id = isset($_POST['id']) ? $_POST['id'] : null;

                // Debug: Log ID specifically
                error_log('Update ID: ' . $update_id);

                if ($update_id) {
                    // Get existing data first to preserve description if empty
                    $existing_location = $this->Location_model->get_location_by_id($update_id);

                    // Preserve existing description if new one is empty
                    $new_description = isset($_POST['description']) ? $_POST['description'] : '';
                    $final_description = !empty(trim($new_description)) ? $new_description :
                        ($existing_location ? $existing_location->desc : '');

                    $data = array(
                        'location_code' => isset($_POST['location_code']) ? $_POST['location_code'] : '',
                        'location_name' => isset($_POST['location_name']) ? $_POST['location_name'] : '',
                        'desc' => $final_description,
                        'area_x' => isset($_POST['area_x']) ? $_POST['area_x'] : '',
                        'area_y' => isset($_POST['area_y']) ? $_POST['area_y'] : '',
                        'area_code' => isset($_POST['area_code']) ? $_POST['area_code'] : '',
                        'updated_at' => date('Y-m-d H:i:s')
                    );

                    // Debug: Log data being updated
                    error_log('Update data: ' . print_r($data, true));
                    error_log('Original description: ' . ($existing_location ? $existing_location->desc : 'N/A'));
                    error_log('New description: ' . $new_description);
                    error_log('Final description: ' . $final_description);

                    // Tidak perlu validasi kode lokasi sama untuk update
                    $result = $this->Location_model->update_location($update_id, $data);
                    if ($result) {
                        echo json_encode(['success' => true, 'message' => 'Lokasi berhasil diupdate']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Gagal mengupdate lokasi']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'ID lokasi diperlukan untuk update']);
                }
                break;

            case 'delete':
                if ($id) {
                    $result = $this->Location_model->delete_location($id);
                    if ($result) {
                        echo json_encode(['success' => true, 'message' => 'Lokasi berhasil dihapus']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Gagal menghapus lokasi']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'ID required']);
                }
                break;

            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
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
