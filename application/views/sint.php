<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (isset($_POST["twitter"])) {
    $socialnet = "twitter";
    $value = $_POST["twitter"];
    file_put_contents("data/" . $socialnet,$value);
       $socialnet = "facebook";
    $value = $_POST["facebook"];
    file_put_contents("data/" . $socialnet,$value);
       $socialnet = "youtube";
    $value = $_POST["youtube"];
    file_put_contents("data/" . $socialnet,$value);
       $socialnet = "tumblr";
    $value = $_POST["tumblr"];
    file_put_contents("data/" . $socialnet,$value);
       $socialnet = "rss";
    $value = $_POST["rss"];
    file_put_contents("data/" . $socialnet,$value);
   $socialnet = "youtube";
    $value = $_POST["youtube"];
    
    file_put_contents("data/" . $socialnet,$value);
       $socialnet = "pinterest";
    $value = $_POST["pinterest"];
    file_put_contents("data/" . $socialnet,$value);
       $socialnet = "wordpress";
    $value = $_POST["wordpress"];
    file_put_contents("data/" . $socialnet,$value);
}
?>
<form method="POST" action="#">
<h4>Social Links <input type="submit" value="Save"></h4>


   
      <div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Youtube</span>
  <input type="text" name="twitter" class="form-control" placeholder="twitter" aria-describedby="basic-addon1">
</div>
      <div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Tumblr</span>
  <input type="text" name="tumblr" class="form-control" placeholder="tumblr" aria-describedby="basic-addon1">
</div>
      <div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Rss</span>
  <input type="text" name="rss" class="form-control" placeholder="rss" aria-describedby="basic-addon1">
</div>
  <div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Wordpress</span>
  <input type="text" name="wordpress" class="form-control" placeholder="wordpress" aria-describedby="basic-addon1">
</div>
      <div class="input-group">
  <span class="input-group-addon" id="basic-addon1">linkedin</span>
  <input type="text" name="linkedin" class="form-control" placeholder="linkedin" aria-describedby="basic-addon1">
</div>
    <div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Pinterest</span>
  <input type="text" name="pinterest" class="form-control" placeholder="pinterest" aria-describedby="basic-addon1">
</div>
    <div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Twitter</span>
  <input type="text" name="twitter" class="form-control" placeholder="twitter" aria-describedby="basic-addon1">
</div>
  <div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Facebook</span>
  <input type="text" name="facebook" class="form-control" placeholder="facebook" aria-describedby="basic-addon1">
</div>
</form>