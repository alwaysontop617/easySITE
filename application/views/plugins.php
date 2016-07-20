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
foreach ($folders as $plugin) {
    if ($plugin == "." || $plugin == "..") {} else {
        
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
                