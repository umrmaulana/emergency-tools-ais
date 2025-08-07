<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Equipment extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_check_auth();
        $this->load->model('emergency_tools/Equipment_model');
    }

    /**
     * Halaman equipment management
     */
    public function index()
    {
        $data['title'] = 'Equipment Management';
        $data['user'] = $this->session->userdata();
        $data['equipments'] = $this->Equipment_model->get_all_equipment();

        $this->load->view('emergency_tools/templates/header', $data);
        $this->load->view('emergency_tools/templates/sidebar', $data);
        $this->load->view('emergency_tools/equipment/index', $data);
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
