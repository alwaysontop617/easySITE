<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	function __construct()
	{
		parent::__construct();
	$this->lang->load('default');
	}
	public function index()
	{
$this->load->view('functions.php');
		if (isset($_GET[file_get_contents("data/admin_url")])) {
		//$this->load->view('bootstrap');
		$this->load->view('top_modal');
$this->load->library('session');
 if(!$this->session->userdata('logged_in'))
   {
   $_SESSION["in"] = "yes";
  $this->load->view('login_system');
   } else {
   	$this->load->view('panel');
   if (isset($_GET["p"])) { $this->load->view($_GET["p"]); } else {$this->load->view("welcome");}
   }
   

   
		$this->load->view('bottom_modal');
		} else {
	
			$this->load->view("bootstrap");
		}
			
		
	} }

