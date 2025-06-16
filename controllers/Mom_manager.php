<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mom_manager extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mom_manager_model');
        $this->load->helper(MOM_MANAGER_MODULE_NAME . '/mom_manager');
        $this->load->language('mom_manager');
    }

    /**
     * Handle add/edit MOM submission
     */
    public function mom($project_id, $id = null)
    {
        if (!has_permission('projects', '', $id ? 'edit' : 'create')) {
            access_denied('mom');
        }

        if ($this->input->post()) {
            $data = [
                'title'        => $this->input->post('title'),
                'content'      => $this->input->post('content', false),
                'meeting_date' => to_sql_date($this->input->post('meeting_date')),
            ];

            if ($id) {
                $success = $this->mom_manager_model->update($id, $data);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('mom_manager_mom_lowercase')));
                }
            } else {
                $data['project_id'] = $project_id;
                $insert_id = $this->mom_manager_model->add($data);
                if ($insert_id) {
                    set_alert('success', _l('added_successfully', _l('mom_manager_mom_lowercase')));
                }
            }

            redirect(admin_url('projects/view/' . $project_id . '?group=mom_manager'));
        }
    }

    /**
     * Delete MOM entry
     */
    public function delete_mom($project_id, $id)
    {
        if (!has_permission('projects', '', 'delete')) {
            access_denied('mom');
        }

        if ($this->mom_manager_model->delete($id)) {
            set_alert('success', _l('deleted', _l('mom_manager_mom_lowercase')));
        }

        redirect(admin_url('projects/view/' . $project_id . '?group=mom_manager'));
    }

    /**
     * Provide MOM data for edit modal
     */
    public function get_mom_data_ajax($id)
    {
        if (!is_staff_member()) {
            ajax_access_denied();
        }

        $mom = $this->mom_manager_model->get($id);
        if ($mom) {
            $mom->content = html_entity_decode($mom->content);
            $mom->meeting_date = _d($mom->meeting_date);
        }

        header('Content-Type: application/json');
        echo json_encode($mom);
    }
}
