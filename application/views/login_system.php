<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 if (isset($_POST["submit"])) {
     $password = md5($_POST["password"]);
     $correct = file_get_contents("data/password_md5");
     if ($password == $correct) {
             $sess_array = array(
         'id' => 'in'
       );
       $this->session->set_userdata('logged_in', $sess_array);
       redirect($_SERVER['REQUEST_URI'], 'refresh'); 
     } else {
         ?>
         <div class="alert alert-danger" role="alert"><?php echo $this->lang->line('error_password'); ?></div>
         <?php
     }
 }
?>
<Center>
<form method="post" action="">
<div class="alert alert-info" role="alert">
     <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <?php echo $this->lang->line('infologin'); ?>
</div>
   <div class="input-group input-group-lg">

  <input type="password" class="form-control" name="password" placeholder="<?php echo $this->lang->line('password'); ?>" aria-describedby="sizing-addon1">
</div>
     <input name="submit" type="submit"  class="btn btn-default" value="<?php echo $this->lang->line('login'); ?>"/>
     
   </form>
   </Center>
