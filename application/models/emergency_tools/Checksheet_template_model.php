<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checksheet_template_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all checksheet templates with equipment type info
     */
    public function get_all_templates($equipment_type_id = null)
    {
        $this->db->select('ct.*, et.equipment_name, et.equipment_type, et.icon_url');
        $this->db->from('tm_checksheet_templates ct');
        $this->db->join('tm_master_equipment_types et', 'et.id = ct.equipment_type_id', 'left');

        if ($equipment_type_id) {
            $this->db->where('ct.equipment_type_id', $equipment_type_id);
        }

        $this->db->order_by('ct.equipment_type_id', 'ASC');
        $this->db->order_by('ct.order_number', 'ASC');

        return $this->db->get()->result();
    }

    /**
     * Get templates by equipment type
     */
    public function get_templates_by_equipment_type($equipment_type_id)
    {
        $this->db->select('ct.*, et.equipment_name, et.equipment_type, et.icon_url');
        $this->db->from('tm_checksheet_templates ct');
        $this->db->join('tm_master_equipment_types et', 'et.id = ct.equipment_type_id', 'left');
        $this->db->where('ct.equipment_type_id', $equipment_type_id);
        $this->db->order_by('ct.order_number', 'ASC');

        return $this->db->get()->result();
    }

    /**
     * Get template by ID
     */
    public function get_template_by_id($id)
    {
        $this->db->select('ct.*, et.equipment_name, et.equipment_type');
        $this->db->from('tm_checksheet_templates ct');
        $this->db->join('tm_master_equipment_types et', 'et.id = ct.equipment_type_id', 'left');
        $this->db->where('ct.id', $id);

        return $this->db->get()->row();
    }

    /**
     * Create new template
     */
    public function create_template($data)
    {
        return $this->db->insert('tm_checksheet_templates', $data);
    }

    /**
     * Update template
     */
    public function update_template($id, $data)
    {
        return $this->db->where('id', $id)->update('tm_checksheet_templates', $data);
    }

    /**
     * Delete template
     */
    public function delete_template($id)
    {
        // Check if template is used in inspections
        $this->db->where('checksheet_item_id', $id);
        $count = $this->db->count_all_results('tr_inspection_details');

        if ($count > 0) {
            return ['success' => false, 'message' => 'Template masih digunakan dalam ' . $count . ' inspeksi'];
        }

        $result = $this->db->where('id', $id)->delete('tm_checksheet_templates');
        return ['success' => $result, 'message' => $result ? 'Template berhasil dihapus' : 'Gagal menghapus template'];
    }

    /**
     * Get next order number for equipment type
     */
    public function get_next_order_number($equipment_type_id)
    {
        $this->db->select_max('order_number');
        $this->db->where('equipment_type_id', $equipment_type_id);
        $result = $this->db->get('tm_checksheet_templates')->row();

        return $result->order_number ? $result->order_number + 1 : 1;
    }

    /**
     * Reorder templates
     */
    public function reorder_templates($equipment_type_id, $template_orders)
    {
        $this->db->trans_start();

        foreach ($template_orders as $template_id => $order_number) {
            $this->db->where('id', $template_id);
            $this->db->where('equipment_type_id', $equipment_type_id);
            $this->db->update('tm_checksheet_templates', ['order_number' => $order_number]);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Count templates by equipment type
     */
    public function count_templates_by_equipment_type()
    {
        $this->db->select('et.id, et.equipment_name as name, et.equipment_type as description, et.icon_url as icon, COUNT(ct.id) as template_count');
        $this->db->from('tm_master_equipment_types et');
        $this->db->join('tm_checksheet_templates ct', 'ct.equipment_type_id = et.id', 'left');
        $this->db->where('et.is_active', 1);
        $this->db->group_by('et.id, et.equipment_name, et.equipment_type, et.icon_url');
        $this->db->order_by('et.equipment_name', 'ASC');

        return $this->db->get()->result();
    }

    /**
     * Get templates grouped by equipment type
     */
    public function get_templates_grouped()
    {
        $templates = $this->get_all_templates();
        $grouped = [];

        foreach ($templates as $template) {
            $equipment_type_id = $template->equipment_type_id;

            if (!isset($grouped[$equipment_type_id])) {
                $grouped[$equipment_type_id] = [
                    'equipment_info' => [
                        'id' => $equipment_type_id,
                        'equipment_name' => $template->equipment_name,
                        'equipment_type' => $template->equipment_type,
                        'icon_url' => $template->icon_url
                    ],
                    'templates' => []
                ];
            }

            $grouped[$equipment_type_id]['templates'][] = $template;
        }

        return $grouped;
    }
}
