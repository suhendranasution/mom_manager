<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Mendapatkan semua MOM untuk sebuah proyek.
 * @param  int $project_id ID Proyek
 * @return array
 */
function get_moms_for_project($project_id)
{
    // Dapatkan instance CodeIgniter agar bisa mengakses model
    $CI = &get_instance(); 
    
    // Panggil fungsi get dari model dengan filter project_id
    return $CI->mom_manager_model->get('', ['project_id' => $project_id]);
}

/**
 * Menghasilkan URL publik untuk sebuah MOM.
 * @param  mixed $mom Bisa berupa object/array MOM atau ID MOM
 * @return string      URL lengkap
 */
function get_mom_public_url($mom)
{
    $CI = &get_instance();
    $hash = '';

    if (is_numeric($mom)) {
        // Jika yang diberikan adalah ID, ambil datanya dulu
        $mom_data = $CI->mom_manager_model->get($mom);
        if ($mom_data) {
            $hash = $mom_data->hash;
        }
    } elseif (is_array($mom)) {
        $hash = $mom['hash'];
    } elseif (is_object($mom)) {
        $hash = $mom->hash;
    }

    if (!empty($hash)) {
        return site_url('mom/view/' . $hash);
    }

    return '';
}