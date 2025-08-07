<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Equipment_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Hitung total equipment
     */
    public function count_total_equipment()
    {
        return $this->db->count_all('tm_equipments');
    }

    /**
     * Get all equipment dengan join location
     */
    public function get_all_equipment()
    {
        $this->db->select('eq.*, loc.location_name');
        $this->db->from('tm_equipments eq');
        $this->db->join('tm_locations loc', 'loc.id = eq.location_id', 'left');
        $this->db->order_by('eq.equipment_code', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Get equipment by ID
     */
    public function get_equipment($id)
    {
        $this->db->select('eq.*, loc.location_name');
        $this->db->from('tm_equipments eq');
        $this->db->join('tm_locations loc', 'loc.id = eq.location_id', 'left');
        $this->db->where('eq.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Insert equipment
     */
    public function insert_equipment($data)
    {
        return $this->db->insert('tm_equipments', $data);
    }

    /**
     * Update equipment
     */
    public function update_equipment($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tm_equipments', $data);
    }

    /**
     * Delete equipment
     */
    public function delete_equipment($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tm_equipments');
    }

    /**
     * Get equipment by location
     */
    public function get_equipment_by_location($location_id)
    {
        $this->db->select('eq.*, loc.location_name');
        $this->db->from('tm_equipments eq');
        $this->db->join('tm_locations loc', 'loc.id = eq.location_id', 'left');
        $this->db->where('eq.location_id', $location_id);
        return $this->db->get()->result();
    }
}
