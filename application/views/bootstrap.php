<?php
//Plugin
if (file_get_contents("data/mmode") == "true" && !$this->session->userdata('logged_in')) {
   $this->load->view("top_modal");
   echo '<h1>Site is on maintainance mode<h1>The developer is currently busy.<br> Please login <a href="?' . file_get_contents("data/admin_url") . '">here</a>';
   $this->load->view("bottom_modal");
}
?>