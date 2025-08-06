<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_checksheet extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_check_auth();
    }

    /**
     * Halaman master checksheet
     */
    public function index()
    {
        $data['title'] = 'Master Checksheet';
        $data['user'] = $this->session->userdata();

        $this->load->view('emergency_tools/templates/header', $data);
        $this->load->view('emergency_tools/templates/sidebar', $data);
        $this->load->view('emergency_tools/master_checksheet/index', $data);
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
