<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (isset($_POST["ok"])) {
    $password = md5($_POST["password"]);
    $key = $_POST["key"];
    file_put_contents("data/admin_url",$key);
    file_put_contents("data/password_md5",$password);
    if (isset($_POST['mmode'])) {
        //Yes
        file_put_contents("data/mmode","true");
    } else {
        file_put_contents("data/mmode","false");
    }
    echo '<div class="alert alert-success" role="alert">Changes Have been Saved</div>';
}
?>

<h1><?php echo $this->lang->line('settingstag'); ?></h1>
<style>
    #password {
    padding: 10px;
    border: 1px solid #000;
    margin: 0 0 10px;
}

div.pass-container {
    height: 30px;
}

div.pass-bar {
    height: 11px;
    margin-top: 2px;
}
div.pass-hint {
    font-family: arial;
    font-size: 11px;
}

</style>
<form method="post" action="#">
<?php echo $this->lang->line('password'); ?>:<input id="password" class="form-control" name="password" type="password" />
<?php echo $this->lang->line('key'); ?>: <input id="password" class="form-control" name="key" type="text" value="<?php echo file_get_contents('data/admin_url'); ?>" />
    <div class="checkbox">
      <label><input name="mmode" type="checkbox" <?php if(file_get_contents('data/mmode')) { echo 'checked'; } ?>><?php echo $this->lang->line('maintainance'); ?></label>
    </div>
  <button type="submit" name="ok" class="btn btn-primary"><?php echo $this->lang->line('submit'); ?></button>
</form>