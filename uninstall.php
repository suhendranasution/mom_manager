<?php
defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

// Menggunakan db_prefix() adalah praktik terbaik
$table_name = db_prefix() . 'mom_manager';

// IF EXISTS mencegah error jika tabel sudah terhapus
// Jalankan query DROP TABLE dengan perlindungan tambahan
$CI->db->query('DROP TABLE IF EXISTS `' . $table_name . '`;');
