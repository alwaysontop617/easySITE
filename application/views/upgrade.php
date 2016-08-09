<?php
defined('BASEPATH') or exit('No direct script access allowed');
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<h1>DYNAMIC UPDATE SYSTEM</h1>

<?php

//Check for an update. We have a simple file that has a new release version on each line. (1.00, 1.02, 1.03, etc.)
$getVersions = file_get_contents('https://raw.githubusercontent.com/alwaysontop617/easySITE/master/latest') or die('No Update Needed.');
$abd = file_get_contents('data/version');
    //If we managed to access that file, then lets break up those release versions into an array.
    echo '<p>CURRENT VERSION: '.$abd.'</p>';
    echo '<p>Reading Current Releases List</p>';
    $versionList = explode('n', $getVersions);
    foreach ($versionList as $aV) {
        if ($aV > $abd) {
            echo '<p>New Update Found: v'.$aV.'</p>';
            $found = true;

            //Download The File If We Do Not Have It
            if (!is_file('master.zip')) {
                echo '<p>Downloading New Update</p>';
                $newUpdate = file_get_contents('https://github.com/alwaysontop617/easySITE/archive/master.zip');
                if (!is_dir('UPDATES/')) {
                    mkdir('UPDATES/');
                }
                $dlHandler = 'UPDATES/master.zip';
                file_put_contents($dlHandler, $newUpdate);

                echo '<p>Update Downloaded And Saved</p>';
            } else {
                echo '<p>Update already downloaded.</p>';
            }

            if ($_GET['doUpdate'] == true) {
                echo '<textarea>';
                //Open The File And Do Stuff
                $zipHandle = zip_open('UPDATES/master.zip');

                while ($aF = zip_read($zipHandle)) {
                    $thisFileName = substr(zip_entry_name($aF), 16);
                    $thisFileDir = '../'.dirname($thisFileName);

                    //Continue if its not a file
                    if (substr($thisFileName, -1, 1) == '/') {
                        continue;
                    }


                    //Make the directory if we need to...
                    if (!is_dir($thisFileDir) && $thisFileDir != 'easySITE-master') {
                        mkdir($thisFileDir);
                        echo '<li>Created Directory '.$thisFileDir.'</li>';
                    }

                    //Overwrite the file
                    if (!is_dir($thisFileName)) {
                        echo ' '.$thisFileName.'...........';
                        $contents = zip_entry_read($aF, zip_entry_filesize($aF));
                        $contents = str_replace('rn', 'n', $contents);
                        $updateThis = '';

                        //If we need to run commands, then do it.
                        if ($thisFileName == 'upgrade.php') {
                            $upgradeExec = fopen('upgrade.php', 'w');
                            fwrite($upgradeExec, $contents);
                            fclose($upgradeExec);
                            include 'upgrade.php';
                            unlink('upgrade.php');
                            echo' EXECUTED ';
                        } else {
                            $updateThis = fopen($thisFileName, 'w');
                            fwrite($updateThis, $contents);
                            fclose($updateThis);
                            unset($contents);
                            echo' UPDATED ';
                        }
                    }
                }
                echo ' ';
                $updated = true;
            } else {
                echo '<p>Update ready. <a href="'.$actual_link.'&doUpdate=true">&raquo; Install Now?</a></p>';
            }
            break;
        }
    }

    if ($updated == true) {
        echo '</textarea>';
        echo '<p class="success">&raquo; Updated to v'.$aV.'</p>';
        file_put_contents('data/version', $aV);
        unlink('UPDATES/master.zip');
    } elseif ($found != true) {
        echo '<p>&raquo; No update is available.</p>';
    }




?>

 
