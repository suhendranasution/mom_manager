<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Minutes of Meeting (MOM) Manager
Description: A module to create and manage Minutes of Meeting for projects and share them with clients.
Version: 1.0.1
Requires at least: 2.3.2
*/

define('MOM_MANAGER_MODULE_NAME', 'mom_manager');

// Daftarkan Helper (sudah benar dari sebelumnya)
$CI = &get_instance();
$CI->load->helper(MOM_MANAGER_MODULE_NAME . '/mom_manager');

// ===================================================================================
// PENDAFTARAN HOOK UNTUK UNINSTALL
// ===================================================================================
register_uninstall_hook(MOM_MANAGER_MODULE_NAME, 'mom_manager_uninstall_hook');

/**
 * Fungsi yang akan dipanggil saat modul di-uninstall.
 * Kosongkan saja jika tidak ada aksi selain database, 
 * karena `uninstall.php` akan menangani database.
 * Keberadaan fungsi ini penting untuk proses uninstall yang bersih.
 */
function mom_manager_uninstall_hook()
{
    // Di sini Anda bisa menambahkan logika lain jika ada,
    // contoh: menghapus data dari tabel `tbloptions`.
    // Untuk sekarang, biarkan kosong.
}
// ===================================================================================

hooks()->add_filter('project_tabs', 'add_mom_project_tab');

/**
 * Register a new tab in the project view area.
 */
function add_mom_project_tab($tabs)
{
    // Untuk menghindari tab rusak karena permission, kita cek di sini
    if (has_permission('projects', '', 'view')) {
        $tabs['mom_manager'] = [
            'name'     => _l('mom_manager'),
            'view'     => 'mom_manager/admin/manage_mom',
            'position' => 30,
            'icon'     => 'fa fa-comments' // Menambahkan ikon untuk konsistensi
        ];
    }
    return $tabs;
}
