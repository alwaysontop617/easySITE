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
 * PDO Forge Class.
 *
 * @category	Database
 *
 * @author		EllisLab Dev Team
 *
 * @link		https://codeigniter.com/database/
 */
class CI_DB_pdo_forge extends CI_DB_forge
{
    /**
     * CREATE TABLE IF statement.
     *
     * @var string
     */
    protected $_create_table_if = false;

    /**
     * DROP TABLE IF statement.
     *
     * @var string
     */
    protected $_drop_table_if = false;
}
