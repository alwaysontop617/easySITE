<?php
session_start();
if (isset($_POST['exit'])) {
    $this->session->unset_userdata('logged_in');
    session_destroy();
    unset($_SESSION['in']);
    redirect($_SERVER['REQUEST_URI'], 'refresh');
}
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="container">

  <ul class="list-inline">
    <li><a  " href="<?php echo $actual_link; ?>&p=welcome"><h3><?php echo $this->lang->line('easysite'); ?></h3></a></li>
    <li><a class="btn btn-primary" href="<?php echo $actual_link; ?>&p=sint"><?php echo $this->lang->line('sint'); ?></a></li>
    <li><a class="btn btn-primary" href="<?php echo $actual_link; ?>&p=backup"><?php echo $this->lang->line('backup'); ?></a></li>
    <li><a class="btn btn-primary" href="<?php echo $actual_link; ?>&p=upgrade">Updates</a></li>
                 <?php
     $key = file_get_contents('data/licence');
    $LICENSE_SERV = 'http://flare.miscy.net/server/check.php?key=';
    $licserv = "$LICENSE_SERV$key";

    $license = file_get_contents($licserv);

    if ($license == 'INVALID') {
        ?>
 <li><a class="btn btn-warning" href="<?php echo $actual_link; ?>&p=Licence">Licence</a></li>
<?php

    } else {
        ?>
 <li><a class="btn btn-primary" href="<?php echo $actual_link; ?>&p=Licence">Licence</a></li>
<?php

    }
?>

    
   
     <li><a  class="btn btn-primary" href="<?php echo $actual_link; ?>&p=plugins"><?php echo $this->lang->line('features'); ?></a></li>
    <li><a class="btn btn-primary" href="<?php echo $actual_link; ?>&p=settings"><?php echo $this->lang->line('settings'); ?></a></li>
    <li><form method="post" action="#"> <button name="exit" type="submit" class="btn btn-danger" value=""><span class="glyphicon glyphicon-stop" aria-hidden="true"></span> <?php echo $this->lang->line('logoff'); ?></button></form></li>
  </ul>
</div>
