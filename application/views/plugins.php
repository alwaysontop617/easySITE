<?php
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<a href="<?php echo $actual_link; ?>&p=searchplugin"><h3><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></h3></a>   
  <?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo '<h1>' . $this->lang->line('features') . '</h1>';
if (isset($_POST["activate"])) {
    $plugin = $_POST["plugin"];
    file_put_contents("data/" . $plugin,"true");
     require("plugins/" . $plugin . "/" . $plugin . ".plugin.php");
     if(function_exists('activated')){
    activated();
}
     
}
if (isset($_POST["deactivate"])) {
    $plugin = $_POST["plugin"];
    file_put_contents("data/" . $plugin,"false");
    require("plugins/" . $plugin . "/" . $plugin . ".plugin.php");
    if(function_exists('deactivated')){
    deactivated();
}
}
?>

 <table class="table table-hover">
    <thead>
      <tr>
        <th>Name</th>
        <th>Version</th>
        <th>About</th>
        <th>Author</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
<?php
$folders = scandir("plugins");
$pl = 0;
foreach ($folders as $plugin) {
    if ($plugin == "." || $plugin == "..") {} else {
        $pl += 1;
        if (!file_exists("data/" . $plugin)) {
            file_put_contents("data/" . $plugin,"false");
        }
        
           $plugin_data = file_get_contents("plugins/" . $plugin . "/" . $plugin . ".plugin.php"); // Load the plugin we want
                  
            preg_match ('|Plugin Name:(.*)$|mi', $plugin_data, $name);
            preg_match ('|Plugin URI:(.*)$|mi', $plugin_data, $uri);
            preg_match ('|Version:(.*)|i', $plugin_data, $version);
            preg_match ('|Description:(.*)$|mi', $plugin_data, $description);
            preg_match ('|Author:(.*)$|mi', $plugin_data, $author_name);
            preg_match ('|Author URI:(.*)$|mi', $plugin_data, $author_uri);
           
           if (file_get_contents("data/" . $plugin) == "false") {
               $activeno =  "<form method='POST' action='#'><input name='plugin' type='hidden' value='" . $plugin . "'><input type='submit' name='activate' value='Activate'></form>";
           } else {
               $activeno =  "<form method='POST' action='#'><input name='plugin' type='hidden' value='" . $plugin . "'><input type='submit' name='deactivate' value='Deactivate'></form>";
           }
           
            echo '
             <tr>
        <td><a href="' . $uri[1]. '">'. $name[1]. '</a></td>
        <td>'. $version[1]. '</td>
        <td>'. $description[1]. '</td>
        <td><a href="' . $author_uri[1]. '">'. $author_name[1]. '</a></td>
        <td>' . $activeno. '</td>
      </tr>
            ';
    }
}
?>
 
    </tbody>
  </table>
             Free Version Limit
             <?php
             if ($pl == "0") {
             ?>
<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="0"
  aria-valuemin="0" aria-valuemax="100" style="width:0%">
    <span class="sr-only">0% Complete</span>
  </div>
</div>
<?php
}
?>
         <?php
          $key=file_get_contents("data/licence");
           $LICENSE_SERV="http://flare.miscy.net/server/check.php?key=";
    $licserv = "$LICENSE_SERV$key";

    $license = file_get_contents($licserv); 
    

         if ($license == "INVALID") {
             if ($pl == "1") {
             ?>
<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="25"
  aria-valuemin="25" aria-valuemax="100" style="width:25%">
    <span class="sr-only">25% Complete</span>
  </div>
</div>
<?php
}
?>
      <?php
             if ($pl == "2") {
             ?>
<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="50"
  aria-valuemin="50" aria-valuemax="100" style="width:50%">
    <span class="sr-only">50% Complete</span>
  </div>
</div>
<?php
}
}
?>