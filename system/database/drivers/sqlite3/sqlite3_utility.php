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
 * SQLite3 Utility Class.
 *
 * @category	Database
 *
 * @author	Andrey Andreev
 *
 * @link	https://codeigniter.com/user_guide/database/
 */
class CI_DB_sqlite3_utility extends CI_DB_utility
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
        // Not supported
        return $this->db->display_error('db_unsupported_feature');
    }
}
