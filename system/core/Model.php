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
 * Model Class.
 *
 * @category	Libraries
 *
 * @author		EllisLab Dev Team
 *
 * @link		https://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model
{
    /**
     * Class constructor.
     *
     * @return void
     */
    public function __construct()
    {
        log_message('info', 'Model Class Initialized');
    }

    // --------------------------------------------------------------------

    /**
     * __get magic.
     *
     * Allows models to access CI's loaded classes using the same
     * syntax as controllers.
     *
     * @param string $key
     */
    public function __get($key)
    {
        // Debugging note:
        //	If you're here because you're getting an error message
        //	saying 'Undefined Property: system/core/Model.php', it's
        //	most likely a typo in your model code.
        return get_instance()->$key;
    }
}
