<?php
error_reporting(0);
/*
This file will install EasySite.
*/
$downloadlocation = "https://github.com/alwaysontop617/easySITE/archive/master.zip";
$folder = "easySITE-master/";
if (isset($_POST["p"])) {
  //start the install
  echo "Grabbing Installation files from ".$downloadlocation;
  file_put_contents("master.zip",file_get_contents($downloadlocation));
  echo "<br>Extracting to " . realpath(".");
  $zip = new ZipArchive;
$res = $zip->open('master.zip');
if ($res === TRUE) {
  $zip->extractTo(realpath("."));
  $zip->close();
}
unlink($folder . "index.php");
  $files = scandir("easySITE-master");
  $oldfolder = $folder;
  $newfolder = realpath(".") . "/";
  foreach($files as $fname) {
      if($fname != '.' && $fname != '..') {
          rename($oldfolder.$fname, $newfolder.$fname);
      }
  }
  function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            self::deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}
  deleteDir("easySITE-master");
  echo "<br>Integrating System(This might take some time)...";
  unlink("index.php");
  $wordpressindex = "
  <?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */
/*
 * Installation of easySITE wordpress integration
 * @package easySite
 * Do not remove any code below this line
 *
 */
 error_reporting(0);
 
/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
require('system.php');
die();
  ";
  file_put_contents("index.php",$wordpressindex);
  echo "<br>The installation is complete, you may now check it out by adding the ?adm123 tag!!";
}
?>

<!doctype html>
<html>
<head>
    <title>Installation</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style type="text/css">
    body {
        background-color: #f0f0f2;
        margin: 0;
        padding: 0;
        font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        
    }
    div {
        width: 600px;
        margin: 5em auto;
        padding: 50px;
        background-color: #fff;
        border-radius: 1em;
    }
    a:link, a:visited {
        color: #38488f;
        text-decoration: none;
    }
    @media (max-width: 700px) {
        body {
            background-color: #fff;
        }
        div {
            width: auto;
            margin: 0 auto;
            border-radius: 0;
            padding: 1em;
        }
    }
    </style>    
</head>

<body>
<div>
    <h1>Installation</h1>
    
    <p><?php 
    if(file_exists("wp-admin") && file_exists("wp-content") && file_exists("wp-includes")) {
        echo "We detected you are using wordpress. You may continue to install the system.";
        if (!file_exists("install.lock")) {
            echo "In order to use the installation files, you must create a file named install.lock. This was created to put a stop to hackers.";
            die();
        }
    } else {
        echo "This system cannot find wordpress unsupported, please place this file in your wordpress directory!!";
        die();
    }
    
    ?></p>
    <p><form method="POST" action="#"><input type="submit" name="p" value="Start Installation"></form></p>
</div>
</body>
</html>