<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_check_auth();
        $this->load->model('emergency_tools/Equipment_model');
        $this->load->model('emergency_tools/Inspection_model');
    }

    /**
     * Halaman report supervisor
     */
    public function index()
    {
        $data['title'] = 'Report - Emergency Tools';
        $data['user'] = $this->session->userdata();

        // Get data for report
        $data['inspections'] = $this->Inspection_model->get_all_inspections(50); // Latest 50 inspections
        $data['pending_count'] = $this->Inspection_model->count_pending_approvals();

        // Get equipment data for map markers
        $data['equipments'] = $this->Equipment_model->get_equipment_with_location();

        $this->load->view('emergency_tools/templates/header', $data);
        $this->load->view('emergency_tools/templates/sidebar', $data);
        $this->load->view('emergency_tools/report/index', $data);
        $this->load->view('emergency_tools/templates/footer', $data);
    }

    /**
     * Approve inspection
     */
    public function approve($inspection_id)
    {
        // Set JSON response header for AJAX requests
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json');
        }

        if ($this->input->post() || $this->input->is_ajax_request()) {
            $notes = $this->input->post('notes');

            $result = $this->Inspection_model->update_approval(
                $inspection_id,
                'approved',
                $this->session->userdata('user_id'),
                $notes
            );

            if ($this->input->is_ajax_request()) {
                if ($result) {
                    $this->output->set_output(json_encode([
                        'success' => true,
                        'message' => 'Inspection berhasil di-approve!'
                    ]));
                } else {
                    $this->output->set_output(json_encode([
                        'success' => false,
                        'message' => 'Gagal approve inspection!'
                    ]));
                }
                return;
            }

            if ($result) {
                $this->session->set_flashdata('success', 'Inspection berhasil di-approve!');
            } else {
                $this->session->set_flashdata('error', 'Gagal approve inspection!');
            }
        }
        redirect('emergency_tools/report');
    }

    /**
     * Reject inspection
     */
    public function reject($inspection_id)
    {
        // Set JSON response header for AJAX requests
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json');
        }

        if ($this->input->post() || $this->input->is_ajax_request()) {
            $notes = $this->input->post('notes');

            $result = $this->Inspection_model->update_approval(
                $inspection_id,
                'rejected',
                $this->session->userdata('user_id'),
                $notes
            );

            if ($this->input->is_ajax_request()) {
                if ($result) {
                    $this->output->set_output(json_encode([
                        'success' => true,
                        'message' => 'Inspection berhasil di-reject!'
                    ]));
                } else {
                    $this->output->set_output(json_encode([
                        'success' => false,
                        'message' => 'Gagal reject inspection!'
                    ]));
                }
                return;
            }

            if ($result) {
                $this->session->set_flashdata('success', 'Inspection berhasil di-reject!');
            } else {
                $this->session->set_flashdata('error', 'Gagal reject inspection!');
            }
        }
        redirect('emergency_tools/report');
    }

    /**
     * Bulk approve inspections
     */
    public function bulk_approve()
    {
        header('Content-Type: application/json');

        $inspection_ids = $this->input->post('inspection_ids');
        $notes = $this->input->post('notes') ?: 'Bulk approved';

        // Validate input
        if (!is_array($inspection_ids) || empty($inspection_ids)) {
            echo json_encode([
                'success' => false,
                'message' => 'No inspections selected for approval'
            ]);
            return;
        }

        $successful = 0;
        $failed = 0;
        $failed_items = [];

        foreach ($inspection_ids as $inspection_id) {
            // Use the correct column name 'id' instead of 'inspection_id'
            $result = $this->Inspection_model->update_approval(
                $inspection_id,
                'approved',
                $this->session->userdata('user_id'),
                $notes
            );

            if ($result) {
                $successful++;
            } else {
                $failed++;
                $failed_items[] = $inspection_id;
            }
        }

        echo json_encode([
            'success' => true,
            'message' => "Bulk approval completed: {$successful} successful, {$failed} failed",
            'data' => [
                'successful' => $successful,
                'failed' => $failed,
                'failed_items' => $failed_items,
                'total' => count($inspection_ids)
            ]
        ]);
    }

    /**
     * API endpoints
     */
    public function api($action = null, $id = null)
    {
        // Set JSON response header
        $this->output->set_content_type('application/json');

        switch ($action) {
            case 'get':
                $this->_api_get_inspections();
                break;
            case 'detail':
                $this->_api_get_inspection_detail($id);
                break;
            default:
                $this->output->set_output(json_encode([
                    'success' => false,
                    'message' => 'Invalid API endpoint'
                ]));
        }
    }

    /**
     * Get inspections data via API
     */
    private function _api_get_inspections()
    {
        try {
            $inspections = $this->Inspection_model->get_all_inspections(100);

            $this->output->set_output(json_encode([
                'success' => true,
                'data' => $inspections,
                'message' => 'Data loaded successfully'
            ]));
        } catch (Exception $e) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Failed to load inspection data: ' . $e->getMessage()
            ]));
        }
    }

    /**
     * Get inspection detail via API
     */
    private function _api_get_inspection_detail($id)
    {
        try {
            if (!$id) {
                throw new Exception('Inspection ID is required');
            }

            $inspection = $this->Inspection_model->get_inspection_detail($id);

            if (!$inspection) {
                throw new Exception('Inspection not found');
            }

            $this->output->set_output(json_encode([
                'success' => true,
                'data' => $inspection,
                'message' => 'Inspection detail loaded successfully'
            ]));
        } catch (Exception $e) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]));
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
