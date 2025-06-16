<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!$CI->db->table_exists(db_prefix() . 'mom_manager')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'mom_manager` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `title` VARCHAR(255) NOT NULL,
        `content` LONGTEXT NOT NULL,
        `meeting_date` DATE NOT NULL,
        `project_id` INT(11) NOT NULL,
        `hash` VARCHAR(32) NOT NULL,
        `created_by` INT(11) NOT NULL,
        `created_at` DATETIME NOT NULL,
        `updated_at` DATETIME NULL,
        PRIMARY KEY (`id`),
        INDEX (`project_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
