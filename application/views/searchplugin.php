<?php

defined('BASEPATH') OR exit('No direct script access allowed');
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
<form method="POST" action="#">
<div class="container">
	<div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div id="imaginary_container"> 
                <div class="input-group stylish-input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search" >
                    <span class="input-group-addon">
                        <button type="submit">
                            <span class="glyphicon glyphicon-search"></span>
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
    echo "<td><a href='http://www.tecflare.com/store/home/" . $plugin->{"id"} . "-" . $plugin->{"link_rewrite"} . ".html'>Download Now</a></td>";
     echo ' </tr>';
    
}
?>

     
      
    </tbody>
  </table>
<a href="http://www.tecflare.com/store/contact-us">Submit your Plugin</a>