<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (isset($_POST["phone"])) {
    $key = $_POST["phone"] . "-" . $_POST["phonea"] . "-" .  $_POST["phoneb"] . "-" . $_POST["phonec"];
              

    $LICENSE_SERV="http://flare.miscy.net/server/check.php?key=";
    $licserv = "$LICENSE_SERV$key";

    $license = file_get_contents($licserv); 
    
    if ($license == "INVALID") { 
?>
<div class="alert alert-danger">Incorrect Licence Key.</div>

<?php


      
   } else {
file_put_contents("data/licence",$key);
?>
<div class="alert alert-success">Correct Licence Key.</div>
<?php
}
}
?>
<h2>Licence this Application 该许可证申请 
la licencia de la aplicación</h2>
<p>
You will need to purchase this application, Before you can activate this system. <br>

You will be downloading checking the licence from Tecflare Authorized and Certified Distributor. The certified Distributor is Orion(miscy.net).<br>

Please Enter Your Licence Key (XXXX-XXXX-XXXX-XXXX) Below.
<style>
    
/*Phone Number Input "hack"*/
.phone-number .col-xs-3::after{
 content: "-";
 position:absolute;
    right: 5px;
    color: black;
    border: 0px solid;
    top: 5px;
  
}

.phone-number .col-xs-4{
	width:25%;
}

.phone-number .col-xs-3, .phone-number .col-xs-4{

	padding-left:0;
}
</style>
<form method="POST" action="#">
<div class="container">
    <div class="col-xs-4">
                <div class="form-group phone-number">
                    
                    <div class="col-xs-3">
                        <input type="tel" name="phone" class="form-control" value="" size="3" maxlength="4" required="required" title="">
                    </div>
                   
                    <div class="col-xs-3 col-xs-4">
                        <input type="tel" name="phonea" class="form-control" value="" size="3" maxlength="4" required="required" title="">
                    </div>
                  

                    <div class="col-xs-3 col-xs-4">
                        <input type="tel" name="phoneb" class="form-control" value="" size="4" maxlength="4" required="required" title="">
                    </div>
                    <div class="col-xs-4 ">
                        <input type="tel" name="phonec" class="form-control" value="" size="4" maxlength="4" required="required" title="">
                    </div>
                </div>
            </div>
            <input type="submit" name="go" value="Submit"/>
</div>
</form>
<br>
</p>