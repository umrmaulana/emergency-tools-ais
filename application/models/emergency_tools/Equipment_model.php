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
     * Get all equipment dengan join location and equipment type
     */
    public function get_all_equipment()
    {
        $this->db->select('eq.*, loc.location_name, et.equipment_name, et.equipment_type');
        $this->db->from('tm_equipments eq');
        $this->db->join('tm_locations loc', 'loc.id = eq.location_id', 'left');
        $this->db->join('tm_master_equipment_types et', 'et.id = eq.equipment_type_id', 'left');
        $this->db->order_by('eq.equipment_code', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Get equipment by ID with joins
     */
    public function get_equipment($id)
    {
        $this->db->select('eq.*, loc.location_name, et.equipment_name, et.equipment_type');
        $this->db->from('tm_equipments eq');
        $this->db->join('tm_locations loc', 'loc.id = eq.location_id', 'left');
        $this->db->join('tm_master_equipment_types et', 'et.id = eq.equipment_type_id', 'left');
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

    /**
     * Get equipment with location coordinates for mapping
     */
    public function get_equipment_with_location()
    {
        $this->db->select('eq.id, eq.equipment_code, eq.status, eq.last_check_date, 
                          loc.location_name, loc.area_x, loc.area_y, loc.area_code,
                          et.equipment_name, et.equipment_type, et.icon_url');
        $this->db->from('tm_equipments eq');
        $this->db->join('tm_locations loc', 'loc.id = eq.location_id', 'left');
        $this->db->join('tm_master_equipment_types et', 'et.id = eq.equipment_type_id', 'left');
        $this->db->where('eq.status !=', 'inactive');
        $this->db->where('loc.area_x IS NOT NULL');
        $this->db->where('loc.area_y IS NOT NULL');
        $this->db->order_by('eq.equipment_code', 'ASC');
        return $this->db->get()->result();
    }
}
