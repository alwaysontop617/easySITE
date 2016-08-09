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
 * SQLite Utility Class.
 *
 * @category	Database
 *
 * @author		EllisLab Dev Team
 *
 * @link		https://codeigniter.com/user_guide/database/
 */
class CI_DB_sqlite_utility extends CI_DB_utility
{
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
