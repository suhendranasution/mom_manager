<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mom_manager extends AdminController
{
    // ... (fungsi __construct, mom, dan delete_mom tetap sama dari sebelumnya) ...

    /**
     * Menyediakan data MOM dalam format JSON untuk form edit.
     * @param int $id ID dari MOM
     */
    public function get_mom_data_ajax($id)
    {
        // Pastikan hanya staff yang bisa mengakses
        if (!is_staff_member()) {
            ajax_access_denied();
        }

        $mom = $this->mom_manager_model->get($id);
        
        // Pastikan konten di-decode dengan benar agar tidak ada entitas aneh
        if ($mom) {
            $mom->content = html_entity_decode($mom->content);
        }

        header('Content-Type: application/json');
        echo json_encode($mom);
    }
}