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
 * Postgre Utility Class.
 *
 * @category	Database
 *
 * @author		EllisLab Dev Team
 *
 * @link		https://codeigniter.com/user_guide/database/
 */
class CI_DB_postgre_utility extends CI_DB_utility
{
    /**
     * List databases statement.
     *
     * @var string
     */
    protected $_list_databases = 'SELECT datname FROM pg_database';

    /**
     * OPTIMIZE TABLE statement.
     *
     * @var string
     */
    protected $_optimize_table = 'REINDEX TABLE %s';

    // --------------------------------------------------------------------

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
