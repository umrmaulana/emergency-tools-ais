<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Equipment_type_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all equipment types
     */
    public function get_all_equipment_types($active_only = false)
    {
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        $this->db->order_by('equipment_name', 'ASC');
        return $this->db->get('tm_master_equipment_types')->result();
    }

    /**
     * Get equipment type by ID
     */
    public function get_equipment_type_by_id($id)
    {
        return $this->db->get_where('tm_master_equipment_types', ['id' => $id])->row();
    }

    /**
     * Create new equipment type
     */
    public function create_equipment_type($data)
    {
        return $this->db->insert('tm_master_equipment_types', $data);
    }

    /**
     * Update equipment type
     */
    public function update_equipment_type($id, $data)
    {
        return $this->db->where('id', $id)->update('tm_master_equipment_types', $data);
    }

    /**
     * Delete equipment type
     */
    public function delete_equipment_type($id)
    {
        // Check if equipment type is used in tm_equipments
        $this->db->where('equipment_type_id', $id);
        $count = $this->db->count_all_results('tm_equipments');

        if ($count > 0) {
            return ['success' => false, 'message' => 'Equipment type masih digunakan oleh ' . $count . ' equipment'];
        }

        $result = $this->db->where('id', $id)->delete('tm_master_equipment_types');
        return ['success' => $result, 'message' => $result ? 'Equipment type berhasil dihapus' : 'Gagal menghapus equipment type'];
    }

    /**
     * Check if equipment type exists
     */
    public function equipment_type_exists($equipment_type, $exclude_id = null)
    {
        $this->db->where('equipment_type', $equipment_type);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results('tm_master_equipment_types') > 0;
    }

    /**
     * Count total equipment types
     */
    public function count_total_equipment_types()
    {
        return $this->db->count_all('tm_master_equipment_types');
    }

    /**
     * Get active equipment types for dropdown
     */
    public function get_active_equipment_types_for_dropdown()
    {
        $this->db->select('id, CONCAT(equipment_name, " - ", equipment_type) as name, equipment_name, equipment_type');
        $this->db->where('is_active', 1);
        $this->db->order_by('equipment_name', 'ASC');
        return $this->db->get('tm_master_equipment_types')->result();
    }
}
