<?php

defined('BASEPATH') OR exit('No direct script access allowed');
if (isset($_POST["path"]) || isset($_POST["email"])) {
    if (!isset($_POST["email"])) {
    echo "<h1>You will be installing " . $_POST["install"] . "</h1>";
   ?>
   1. Before we begin the installer you will need to  <a target="_blank" href="<?php echo $_POST["path"];?>">Click Here</a>.<br>
   2. Buy the Product, after that you will need to download the files.
   
   <form method ="POST" action="#" enctype="multipart/form-data">
       <input type="hidden" name="email" >
      <label>3.Please upload the file you downloaded: <input type="file" name="zip_file" /></label>
      <input type="submit" value="Install Now">
<br />
   </form>
   <?php
    } else {
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <h1>Starting Installation</h1>
        <?php
        echo "Uploading file...";
        $target_dir = "plugins/";
   $target_file = $target_dir . basename($_FILES["zip_file"]["name"]);
   move_uploaded_file($_FILES["zip_file"]["tmp_name"], $target_file);
   echo "<br>The file has been uploaded successfully.<br>Extracting and Installing Plugin...";
   $zip = new ZipArchive;
$res = $zip->open($target_dir . basename($_FILES["zip_file"]["name"]));
if ($res === TRUE) {
  $zip->extractTo('plugins/');
  $zip->close();
  unlink($target_dir . basename($_FILES["zip_file"]["name"]));
  echo '<br>The plugin has been install successfully.';
} else {
  echo '<br>An Unexpected Error has Happened. Please Try Again.';
}

        ?>
        <li><a href="<?php echo $actual_link; ?>&p=plugins">Back to <?php echo $this->lang->line('features'); ?></a></li>
        <?php
    }
} else {
?>

<style>
  
.stylish-input-group .input-group-addon{
    background: white !important; 
}
.stylish-input-group .form-control{
	border-right:0; 
	box-shadow:0 0 0; 
	border-color:#ccc;
}
.stylish-input-group button{
    border:0;
    background:transparent;
}
</style>
<form method="GET" action="http://www.tecflare.com/store/search">
<div class="container">
	<div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div id="imaginary_container"> 
                <div class="input-group stylish-input-group">
                    <input type="hidden" name="controller" value="search" /> <input type="hidden" name="orderby" value="position" /> <input type="hidden" name="orderway" value="desc" />
                    <input type="text" class="form-control" name="search_query" placeholder="Search" >
                    <span class="input-group-addon">
                        <button type="submit">
                            <div style="color:black">SEARCH</div>
                        </button>  
                    </span>
                </div>
            </div>
        </div>
	</div>
</div>
</form>
 <table class="table table-striped">
    <thead>
      <tr>
        <th>Name of Plugin</th>
        <th>Description of Plugin</th>
        <th>Price</th>
        <th>Download</th>
      </tr>
    </thead>
    <tbody>
        <?php
        if (isset($_POST["search"])) {
            $url = "https://R55T99AZTFVCBNMCYAZCQ213YIWNPXHS@www.tecflare.com/store/api/products/?display=full&output_format=JSON&date=1&language=1&query=" . $_POST["search"];

        } else {
$url = "https://R55T99AZTFVCBNMCYAZCQ213YIWNPXHS@www.tecflare.com/store/api/products/?display=full&output_format=JSON&language=1&date=1&query=";
}
$each =json_decode(file_get_contents($url));
foreach ($each->{"products"} as $plugin)
{
    
    echo' <tr>';
 

    echo "<td>" . $plugin->{"name"} . "</td>";
    echo "<td>" . $plugin->{"description"}  . "</td>";
    if ($plugin->{"wholesale_price"} == "0.000000") {
        echo "<td>FREE</td>";
    } else {
    echo  "<td>" . $plugin->{"wholesale_price"}  . "</td>";
    }
    echo "<td><form method='POST' action=''><input type='submit' value='Download Now'><input type='hidden' name='install' value='" .$plugin->{"name"} ."'><input type='hidden' name='path' value='http://www.tecflare.com/store/home/" . $plugin->{"id"} . "-" . $plugin->{"link_rewrite"} . ".html'></form></td>";
     echo ' </tr>';
    
}
?>

     
      
    </tbody>
  </table>
<a href="http://www.tecflare.com/store/contact-us">Submit your Plugin</a>
<?php
}
?>