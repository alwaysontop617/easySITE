<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
$lang_english[""];
$lang_spanish[""];
$lang_chinese[""];
function bootstrap_alert($p,$c) {
    return('<div class="alert alert-' . $c. '">
  ' . $p . '
</div>');
}
function language_register($p,$c) {
    global $lang_english;
    global $lang_spanish;
    global $lang_chinese;
if ($c == "english") {
    $arr = sizeof($lang_english) + 1;
    $lang_english[$arr] = $p;
}   
if ($c == "chinese") {
    $arr = sizeof($lang_chinese) + 1;
   $lang_chinese[$arr] = $p; 
}  
if ($c == "spanish") {
    $arr = sizeof($lang_spanish) + 1;
    $lang_spanish[$arr] = $p;
}  
return $arr;
}
function language_call($m) {
      global $lang_english;
    global $lang_spanish;
    global $lang_chinese;
    $lang = file_get_contents("data/language");
    if ($lang == "english") {
      return  $lang_english[$m]; 
    }
    if ($lang == "chinese") {
        return  $lang_chinese[$m]; 
    }
    if ($lang == "spanish") {
        return  $lang_spanish[$m]; 
    }
}
?>
