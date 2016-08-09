<?php

/*
 * Tecflare Corporation Technology
 *
 * Copyright (c) Tecflare All Rights reserved
 *
 * This code is copyrighted to Tecflare!!
 *
 */

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Oracle Utility Class.
 *
 * @category	Database
 *
 * @author		EllisLab Dev Team
 *
 * @link		https://codeigniter.com/user_guide/database/
 */
class CI_DB_oci8_utility extends CI_DB_utility
{
    /**
     * List databases statement.
     *
     * @var string
     */
    protected $_list_databases = 'SELECT username FROM dba_users'; // Schemas are actual usernames

    /**
     * Export.
     *
     * @param array $params Preferences
     *
     * @return mixed
     */
    protected function _backup($params = [])
    {
        // Currently unsupported
        return $this->db->display_error('db_unsupported_feature');
    }
}
