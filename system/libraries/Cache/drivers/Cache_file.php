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
 * CodeIgniter File Caching Class.
 *
 * @category	Core
 *
 * @author		EllisLab Dev Team
 *
 * @link
 */
class CI_Cache_file extends CI_Driver
{
    /**
     * Directory in which to save cache files.
     *
     * @var string
     */
    protected $_cache_path;

    /**
     * Initialize file-based cache.
     *
     * @return void
     */
    public function __construct()
    {
        $CI = &get_instance();
        $CI->load->helper('file');
        $path = $CI->config->item('cache_path');
        $this->_cache_path = ($path === '') ? APPPATH.'cache/' : $path;
    }

    // ------------------------------------------------------------------------

    /**
     * Fetch from cache.
     *
     * @param string $id Cache ID
     *
     * @return mixed Data on success, FALSE on failure
     */
    public function get($id)
    {
        $data = $this->_get($id);

        return is_array($data) ? $data['data'] : false;
    }

    // ------------------------------------------------------------------------

    /**
     * Save into cache.
     *
     * @param string $id   Cache ID
     * @param mixed  $data Data to store
     * @param int    $ttl  Time to live in seconds
     * @param bool   $raw  Whether to store the raw value (unused)
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function save($id, $data, $ttl = 60, $raw = false)
    {
        $contents = [
            'time'        => time(),
            'ttl'         => $ttl,
            'data'        => $data,
        ];

        if (write_file($this->_cache_path.$id, serialize($contents))) {
            chmod($this->_cache_path.$id, 0640);

            return true;
        }

        return false;
    }

    // ------------------------------------------------------------------------

    /**
     * Delete from Cache.
     *
     * @param	mixed	unique identifier of item in cache
     *
     * @return bool true on success/false on failure
     */
    public function delete($id)
    {
        return file_exists($this->_cache_path.$id) ? unlink($this->_cache_path.$id) : false;
    }

    // ------------------------------------------------------------------------

    /**
     * Increment a raw value.
     *
     * @param string $id     Cache ID
     * @param int    $offset Step/value to add
     *
     * @return New value on success, FALSE on failure
     */
    public function increment($id, $offset = 1)
    {
        $data = $this->_get($id);

        if ($data === false) {
            $data = ['data' => 0, 'ttl' => 60];
        } elseif (!is_int($data['data'])) {
            return false;
        }

        $new_value = $data['data'] + $offset;

        return $this->save($id, $new_value, $data['ttl'])
            ? $new_value
            : false;
    }

    // ------------------------------------------------------------------------

    /**
     * Decrement a raw value.
     *
     * @param string $id     Cache ID
     * @param int    $offset Step/value to reduce by
     *
     * @return New value on success, FALSE on failure
     */
    public function decrement($id, $offset = 1)
    {
        $data = $this->_get($id);

        if ($data === false) {
            $data = ['data' => 0, 'ttl' => 60];
        } elseif (!is_int($data['data'])) {
            return false;
        }

        $new_value = $data['data'] - $offset;

        return $this->save($id, $new_value, $data['ttl'])
            ? $new_value
            : false;
    }

    // ------------------------------------------------------------------------

    /**
     * Clean the Cache.
     *
     * @return bool false on failure/true on success
     */
    public function clean()
    {
        return delete_files($this->_cache_path, false, true);
    }

    // ------------------------------------------------------------------------

    /**
     * Cache Info.
     *
     * Not supported by file-based caching
     *
     * @param	string	user/filehits
     *
     * @return mixed FALSE
     */
    public function cache_info($type = null)
    {
        return get_dir_file_info($this->_cache_path);
    }

    // ------------------------------------------------------------------------

    /**
     * Get Cache Metadata.
     *
     * @param	mixed	key to get cache metadata on
     *
     * @return mixed FALSE on failure, array on success.
     */
    public function get_metadata($id)
    {
        if (!file_exists($this->_cache_path.$id)) {
            return false;
        }

        $data = unserialize(file_get_contents($this->_cache_path.$id));

        if (is_array($data)) {
            $mtime = filemtime($this->_cache_path.$id);

            if (!isset($data['ttl'])) {
                return false;
            }

            return [
                'expire'    => $mtime + $data['ttl'],
                'mtime'     => $mtime,
            ];
        }

        return false;
    }

    // ------------------------------------------------------------------------

    /**
     * Is supported.
     *
     * In the file driver, check to see that the cache directory is indeed writable
     *
     * @return bool
     */
    public function is_supported()
    {
        return is_really_writable($this->_cache_path);
    }

    // ------------------------------------------------------------------------

    /**
     * Get all data.
     *
     * Internal method to get all the relevant data about a cache item
     *
     * @param string $id Cache ID
     *
     * @return mixed Data array on success or FALSE on failure
     */
    protected function _get($id)
    {
        if (!is_file($this->_cache_path.$id)) {
            return false;
        }

        $data = unserialize(file_get_contents($this->_cache_path.$id));

        if ($data['ttl'] > 0 && time() > $data['time'] + $data['ttl']) {
            unlink($this->_cache_path.$id);

            return false;
        }

        return $data;
    }
}
