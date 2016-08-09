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
 * SessionHandlerInterface.
 *
 * PHP 5.4 compatibility interface
 *
 * @category	Sessions
 *
 * @author	Andrey Andreev
 *
 * @link	https://codeigniter.com/user_guide/libraries/sessions.html
 */
interface SessionHandlerInterface
{
    public function open($save_path, $name);

    public function close();

    public function read($session_id);

    public function write($session_id, $session_data);

    public function destroy($session_id);

    public function gc($maxlifetime);
}
