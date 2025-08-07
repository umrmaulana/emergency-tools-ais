<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_check_auth();
        $this->load->model('emergency_tools/Equipment_model');
        $this->load->model('emergency_tools/Inspection_model');
    }

    /**
     * Halaman dashboard supervisor
     */
    public function index()
    {
        $data['title'] = 'Dashboard Equipment - Emergency Tools';
        $data['user'] = $this->session->userdata();

        // Get statistics
        $data['total_equipment'] = $this->Equipment_model->count_total_equipment();
        $data['equipment_checked_today'] = $this->Inspection_model->count_checked_today();
        $data['pending_approvals'] = $this->Inspection_model->count_pending_approvals();
        $data['chart_data'] = $this->Inspection_model->get_chart_data();

        $this->load->view('emergency_tools/templates/header', $data);
        $this->load->view('emergency_tools/templates/sidebar', $data);
        $this->load->view('emergency_tools/dashboard/index', $data);
        $this->load->view('emergency_tools/templates/footer', $data);
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
