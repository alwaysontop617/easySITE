<?php
//Plugin
if (file_get_contents('data/mmode') == 'true' && !$this->session->userdata('logged_in')) {
    $this->load->view('top_modal');
    echo '<h1>Site is on maintainance mode<h1>The developer is currently busy.<br> Please login <a href="?'.file_get_contents('data/admin_url').'">here</a>';
    $this->load->view('bottom_modal');
}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<style type="text/css">
   .sticky-container {
/*background-color: #333;*/
padding: 0px;
margin: 0px;
position: fixed;
right: -119px;
top: 130px;
width: 200px;
}
.sticky li {
list-style-type: none;
background-color: #333;
color: #efefef;
height: 43px;
padding: 0px;
margin: 0px 0px 1px 0px;
-webkit-transition: all 0.25s ease-in-out;
-moz-transition: all 0.25s ease-in-out;
-o-transition: all 0.25s ease-in-out;
transition: all 0.25s ease-in-out;
cursor: pointer;
filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale");
filter: gray;
-webkit-filter: grayscale(100%);
}
.sticky li:hover {
margin-left: -115px;
/*-webkit-transform: translateX(-115px);
		-moz-transform: translateX(-115px);
		-o-transform: translateX(-115px);
		-ms-transform: translateX(-115px);
		transform:translateX(-115px);*/
		/*background-color: #8e44ad;*/
filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'1 0 0 0 0, 0 1 0 0 0, 0 0 1 0 0, 0 0 0 1 0\'/></filter></svg>#grayscale");
-webkit-filter: grayscale(0%);
}
.sticky li img {
float: left;
margin: 5px 5px;
margin-right: 10px;
}
.sticky li p {
padding: 0px;
margin: 0px;
text-transform: uppercase;
line-height: 43px;
}
</style>
<div class="sticky-container">
<ul class="sticky">
<li> <h2>F</h2><a type="button" class="btn btn-small" href="<?php echo file_get_contents('data/facebook'); ?>"><span style="width:32%; height:32%;" class="fa fa-facebook fa-2x" aria-hidden="true"></span>
<p>Facebook</p></a>
</li>
<li><h2>T</h2> <a type="button" class="btn btn-small" href="<?php echo file_get_contents('data/twitter'); ?>"><span style="width:32%; height:32%;" class="fa fa-twitter fa-2x" aria-hidden="true"></span>
<p>Twitter</p></a>
</li>
<li><h2>P</h2> <a type="button" class="btn btn-small" href="<?php echo file_get_contents('data/pinterest'); ?>"><span style="width:32%; height:32%;" class="fa fa-pinterest fa-2x" aria-hidden="true"></span>
<p>Pinterest</p></a>
</li>
<li><h2>L</h2> <a type="button" class="btn btn-small" href="<?php echo file_get_contents('data/linkedin'); ?>"><span style="width:32%; height:32%;" class="fa fa-linkedin fa-2x" aria-hidden="true"></span>
<p>Linkedin</p></a>
</li>
<li><h2>R</h2> <a type="button" class="btn btn-small" href="<?php echo file_get_contents('data/rss'); ?>"><span style="width:32%; height:32%;" class="fa fa-rss fa-2x" aria-hidden="true"></span>
<p>RSS</p></a>
</li>
<li><h2>T</h2> <a type="button" class="btn btn-small" href="<?php echo file_get_contents('data/tumblr'); ?>"><span style="width:32%; height:32%;" class="fa fa-tumblr fa-2x" aria-hidden="true"></span>
<p>Tumblr</p></a>
</li>
<li><h2>W</h2> <a type="button" class="btn btn-small" href="<?php echo file_get_contents('data/wordpress'); ?>"><span style="width:32%; height:32%;" class="fa fa-wordpress fa-2x" aria-hidden="true"></span>
<p>Wordpress</p></a>
</li>
<li> <h2>Y</h2><a type="button" class="btn btn-small"href="<?php echo file_get_contents('data/youtube'); ?>"><span style="width:32%; height:32%;" class="fa fa-youtube fa-2x" aria-hidden="true"></span>
<p>Youtube</p></a>
<li> <h2></h2>
</li>
</ul>
</div>
