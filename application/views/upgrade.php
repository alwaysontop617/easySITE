<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<h1>DYNAMIC UPDATE SYSTEM</h1>

<?php

//Check for an update. We have a simple file that has a new release version on each line. (1.00, 1.02, 1.03, etc.)
$getVersions = file_get_contents('http://your-server.com/CMS-UPDATE-PACKAGES/current-release-versions.php') or die("No Update Needed.");
$getVersions = 2;
$abd = "1";
    //If we managed to access that file, then lets break up those release versions into an array.
    echo '<p>CURRENT VERSION: '.$abd.'</p>';
    echo '<p>Reading Current Releases List</p>';
    $versionList = explode("n", $getVersions);    
    foreach ($versionList as $aV)
    {
        if ( $aV > $abd) {
            echo '<p>New Update Found: v'.$aV.'</p>';
            $found = true;
           
            //Download The File If We Do Not Have It
            if ( !is_file(  'master.zip' )) {
                echo '<p>Downloading New Update</p>';
                $newUpdate = file_get_contents("https://github.com/alwaysontop617/easySITE/archive/master.zip");
                if ( !is_dir( 'UPDATES/' ) ) mkdir ( 'UPDATES/' );
                $dlHandler ="UPDATES/master.zip";
                file_put_contents($dlHandler, $newUpdate);
                
                echo '<p>Update Downloaded And Saved</p>';
            } else echo '<p>Update already downloaded.</p>';    
           
            if ($_GET['doUpdate'] == true) {
                //Open The File And Do Stuff
                $zipHandle = zip_open('update.zip');
                echo '<ul>';
                while ($aF = zip_read($zipHandle) )
                {
                    $thisFileName = zip_entry_name($aF);
                    $thisFileDir = dirname($thisFileName);
                   
                    //Continue if its not a file
                    if ( substr($thisFileName,-1,1) == '/') continue;
                   
    
                    //Make the directory if we need to...
                    if ( !is_dir ( $_ENV['site']['files']['server-root'].'/'.$thisFileDir ) )
                    {
                         mkdir ( $_ENV['site']['files']['server-root'].'/'.$thisFileDir );
                         echo '<li>Created Directory '.$thisFileDir.'</li>';
                    }
                   
                    //Overwrite the file
                    if ( !is_dir($_ENV['site']['files']['server-root'].'/'.$thisFileName) ) {
                        echo '<li>'.$thisFileName.'...........';
                        $contents = zip_entry_read($aF, zip_entry_filesize($aF));
                        $contents = str_replace("rn", "n", $contents);
                        $updateThis = '';
                       
                        //If we need to run commands, then do it.
                        if ( $thisFileName == 'upgrade.php' )
                        {
                            $upgradeExec = fopen ('upgrade.php','w');
                            fwrite($upgradeExec, $contents);
                            fclose($upgradeExec);
                            include ('upgrade.php');
                            unlink('upgrade.php');
                            echo' EXECUTED</li>';
                        }
                        else
                        {
                            $updateThis = fopen($_ENV['site']['files']['server-root'].'/'.$thisFileName, 'w');
                            fwrite($updateThis, $contents);
                            fclose($updateThis);
                            unset($contents);
                            echo' UPDATED</li>';
                        }
                    }
                }
                echo '</ul>';
                $updated = TRUE;
            }
            else echo '<p>Update ready. <a href="' . $actual_link. '?doUpdate=true">&raquo; Install Now?</a></p>';
            break;
        }
    }
    
    if ($updated == true)
    {
        set_setting('site','CMS',$aV);
        echo '<p class="success">&raquo; CMS Updated to v'.$aV.'</p>';
    }
    else if ($found != true) echo '<p>&raquo; No update is available.</p>';

    


?>

 
