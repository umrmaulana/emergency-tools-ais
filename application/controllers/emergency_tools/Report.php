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
        if ($this->input->post()) {
            $result = $this->Inspection_model->update_approval(
                $inspection_id,
                'approved',
                $this->session->userdata('user_id')
            );

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
        if ($this->input->post()) {
            $result = $this->Inspection_model->update_approval(
                $inspection_id,
                'rejected',
                $this->session->userdata('user_id')
            );

            if ($result) {
                $this->session->set_flashdata('success', 'Inspection berhasil di-reject!');
            } else {
                $this->session->set_flashdata('error', 'Gagal reject inspection!');
            }
        }
        redirect('emergency_tools/report');
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
