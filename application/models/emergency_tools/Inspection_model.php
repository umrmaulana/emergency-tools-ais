<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inspection_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Hitung equipment yang dicek hari ini
     */
    public function count_checked_today()
    {
        $today = date('Y-m-d');
        $this->db->where('DATE(inspection_date)', $today);
        return $this->db->count_all_results('tr_inspections');
    }

    /**
     * Hitung pending approvals
     */
    public function count_pending_approvals()
    {
        $this->db->where('approval_status', 'pending');
        return $this->db->count_all_results('tr_inspections');
    }

    /**
     * Get data untuk chart (7 hari terakhir)
     */
    public function get_chart_data()
    {
        $result = array();

        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $this->db->where('DATE(inspection_date)', $date);
            $count = $this->db->count_all_results('tr_inspections');

            $result[] = array(
                'date' => date('d M', strtotime($date)),
                'count' => $count
            );
        }

        return $result;
    }

    /**
     * Get all inspections with equipment and user info
     */
    public function get_all_inspections($limit = null, $offset = null)
    {
        $this->db->select('insp.*, eq.equipment_code, eq.equipment_type_id, u.name as inspector_name,
                          et.equipment_name, et.equipment_type, loc.location_name, u.level as inspector_level');
        $this->db->from('tr_inspections insp');
        $this->db->join('tm_equipments eq', 'eq.id = insp.equipment_id', 'left');
        $this->db->join('users u', 'u.id = insp.user_id', 'left');
        $this->db->join('tm_master_equipment_types et', 'et.id = eq.equipment_type_id', 'left');
        $this->db->join('tm_locations loc', 'loc.id = eq.location_id', 'left');
        $this->db->order_by('insp.inspection_date', 'DESC');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }

    /**
     * Get inspections by equipment
     */
    public function get_inspections_by_equipment($equipment_id)
    {
        $this->db->select('insp.*, u.name as inspector_name');
        $this->db->from('tr_inspections insp');
        $this->db->join('users u', 'u.id = insp.user_id', 'left');
        $this->db->where('insp.equipment_id', $equipment_id);
        $this->db->order_by('insp.inspection_date', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Insert inspection
     */
    public function insert_inspection($data)
    {
        return $this->db->insert('tr_inspections', $data);
    }

    /**
     * Update inspection approval
     */
    public function update_approval($inspection_id, $approval_status, $approved_by, $notes = null)
    {
        $data = array(
            'approval_status' => $approval_status,
            'approved_by' => $approved_by,
            'updated_at' => date('Y-m-d H:i:s')
        );

        if ($notes) {
            $data['notes'] = $notes;
        }

        $this->db->where('id', $inspection_id);
        return $this->db->update('tr_inspections', $data);
    }

    /**
     * Get inspection detail by ID
     */
    public function get_inspection_detail($inspection_id)
    {
        return $this->get_inspection_details($inspection_id);
    }

    /**
     * Get inspection details dengan detail items
     */
    public function get_inspection_details($inspection_id)
    {
        $this->db->select('insp.*, eq.equipment_code, eq.equipment_type_id, u.name as inspector_name, 
                          app_user.name as approved_by_name');
        $this->db->from('tr_inspections insp');
        $this->db->join('tm_equipments eq', 'eq.id = insp.equipment_id', 'left');
        $this->db->join('users u', 'u.id = insp.user_id', 'left');
        $this->db->join('users app_user', 'app_user.id = insp.approved_by', 'left');
        $this->db->where('insp.id', $inspection_id);

        $inspection = $this->db->get()->row();

        if ($inspection) {
            // Get detail items
            $this->db->select('det.*, cs.item_name, cs.standar_condition');
            $this->db->from('tr_inspection_details det');
            $this->db->join('tm_checksheet_templates cs', 'cs.id = det.checksheet_item_id', 'left');
            $this->db->where('det.inspection_id', $inspection_id);
            $inspection->details = $this->db->get()->result();
        }

        return $inspection;
    }
}
