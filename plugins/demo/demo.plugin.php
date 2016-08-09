<?php

/*
 * Tecflare Corporation Technology
 *
 * Copyright (c) Tecflare All Rights reserved
 *
 * This code is copyrighted to Tecflare!!
 *
 */

function activated()
{
    echo bootstrap_alert('Plugin has been activated!!', 'success');
}
function deactivated()
{
    $hello = language_register('Plugin has been deactived', 'english');
    language_register('Plugin ha sido deactived', 'spanish');
    language_register('插件已被停用', 'chinese');
    echo bootstrap_alert(language_call($hello), 'danger');
}
