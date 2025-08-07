<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all locations
     */
    public function get_all_locations($limit = null)
    {
        if ($limit) {
            $this->db->limit($limit);
        }

        $this->db->order_by('location_code', 'ASC');
        return $this->db->get('tm_locations')->result();
    }

    /**
     * Get location by ID
     */
    public function get_location_by_id($id)
    {
        return $this->db->get_where('tm_locations', ['id' => $id])->row();
    }

    /**
     * Create new location
     */
    public function create_location($data)
    {
        return $this->db->insert('tm_locations', $data);
    }

    /**
     * Update location
     */
    public function update_location($id, $data)
    {
        return $this->db->where('id', $id)->update('tm_locations', $data);
    }

    /**
     * Delete location
     */
    public function delete_location($id)
    {
        return $this->db->where('id', $id)->delete('tm_locations');
    }

    /**
     * Get location by area coordinates
     */
    public function get_location_by_area($area_x, $area_y)
    {
        return $this->db->get_where('tm_locations', [
            'area_x' => $area_x,
            'area_y' => $area_y
        ])->row();
    }

    /**
     * Check if area is occupied
     */
    public function is_area_occupied($area_x, $area_y, $exclude_id = null)
    {
        $this->db->where('area_x', $area_x);
        $this->db->where('area_y', $area_y);

        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }

        return $this->db->count_all_results('tm_locations') > 0;
    }

    /**
     * Get locations for specific area range
     */
    public function get_locations_by_area_range($min_x, $max_x, $min_y, $max_y)
    {
        $this->db->where('area_x >=', $min_x);
        $this->db->where('area_x <=', $max_x);
        $this->db->where('area_y >=', $min_y);
        $this->db->where('area_y <=', $max_y);

        return $this->db->get('tm_locations')->result();
    }

    /**
     * Count total locations
     */
    public function count_total_locations()
    {
        return $this->db->count_all('tm_locations');
    }

    /**
     * Get locations for dropdown
     */
    public function get_locations_for_dropdown()
    {
        $this->db->select('id, location_name as name');
        $this->db->order_by('location_name', 'ASC');
        return $this->db->get('tm_locations')->result();
    }
}
