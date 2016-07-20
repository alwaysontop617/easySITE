<?php
/**
* Plugin Name: DEMO Plugin
* Plugin URI: http://example.com
* Version: 1.0
* Description: example plugin used for development
* Author: Someone
* Author URI: http://example.com
*/
function activated() {
    echo bootstrap_alert("Plugin has been activated!!","success");
}
function deactivated() {
      $hello = language_register("Plugin has been deactived","english");
      language_register("Plugin ha sido deactived","spanish");
      language_register("插件已被停用","chinese");
    echo bootstrap_alert(language_call($hello),"danger");
}
?>