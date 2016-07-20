<?php
if (file_get_contents("data/mmode") == "true" && !$this->session->userdata('logged_in')) {
   $this->load->view("top_modal");
   echo 'Site is on maintainance mode, Please login <a href="?' . file_get_contents("data/admin_url") . '">here</a>';
   $this->load->view("bottom_modal");
}
?>