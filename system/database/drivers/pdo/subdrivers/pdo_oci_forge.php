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
 * PDO Oracle Forge Class.
 *
 * @category	Database
 *
 * @author		EllisLab Dev Team
 *
 * @link		https://codeigniter.com/user_guide/database/
 */
class CI_DB_pdo_oci_forge extends CI_DB_pdo_forge
{
    /**
     * CREATE DATABASE statement.
     *
     * @var string
     */
    protected $_create_database = false;

    /**
     * DROP DATABASE statement.
     *
     * @var string
     */
    protected $_drop_database = false;

    /**
     * CREATE TABLE IF statement.
     *
     * @var string
     */
    protected $_create_table_if = 'CREATE TABLE IF NOT EXISTS';

    /**
     * UNSIGNED support.
     *
     * @var bool|array
     */
    protected $_unsigned = false;

    // --------------------------------------------------------------------

    /**
     * ALTER TABLE.
     *
     * @param string $alter_type ALTER type
     * @param string $table      Table name
     * @param mixed  $field      Column definition
     *
     * @return string|string[]
     */
    protected function _alter_table($alter_type, $table, $field)
    {
        if ($alter_type === 'DROP') {
            return parent::_alter_table($alter_type, $table, $field);
        } elseif ($alter_type === 'CHANGE') {
            $alter_type = 'MODIFY';
        }

        $sql = 'ALTER TABLE '.$this->db->escape_identifiers($table);
        $sqls = [];
        for ($i = 0, $c = count($field); $i < $c; $i++) {
            if ($field[$i]['_literal'] !== false) {
                $field[$i] = "\n\t".$field[$i]['_literal'];
            } else {
                $field[$i]['_literal'] = "\n\t".$this->_process_column($field[$i]);

                if (!empty($field[$i]['comment'])) {
                    $sqls[] = 'COMMENT ON COLUMN '
                        .$this->db->escape_identifiers($table).'.'.$this->db->escape_identifiers($field[$i]['name'])
                        .' IS '.$field[$i]['comment'];
                }

                if ($alter_type === 'MODIFY' && !empty($field[$i]['new_name'])) {
                    $sqls[] = $sql.' RENAME COLUMN '.$this->db->escape_identifiers($field[$i]['name'])
                        .' '.$this->db->escape_identifiers($field[$i]['new_name']);
                }
            }
        }

        $sql .= ' '.$alter_type.' ';
        $sql .= (count($field) === 1)
                ? $field[0]
                : '('.implode(',', $field).')';

        // RENAME COLUMN must be executed after MODIFY
        array_unshift($sqls, $sql);

        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * Field attribute AUTO_INCREMENT.
     *
     * @param array &$attributes
     * @param array &$field
     *
     * @return void
     */
    protected function _attr_auto_increment(&$attributes, &$field)
    {
        // Not supported - sequences and triggers must be used instead
    }
}
