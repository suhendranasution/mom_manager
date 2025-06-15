<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Public_mom extends App_Controller
{
    public function view($hash)
    {
        $this->load->model('mom_manager_model');
        $data['mom'] = $this->mom_manager_model->get_by_hash($hash);

        if (!$data['mom']) {
            show_404();
        }

        // Nonaktifkan layout utama Perfex
        $this->app_css->reset(true);
        $this->app_scripts->reset(true);

        $this->load->view('mom_manager/public/view_mom_public', $data);
    }
}