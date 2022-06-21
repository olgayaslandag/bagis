<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Single extends CI_Controller{

	public function __construct(){

		parent::__construct();
		$this->load->model("Single_Model");

	}

	public function index($id){

		$icerik = $this->Single_Model->get(["post_id" => $id]);
		$data["icerik"] = $icerik[0];
		$this->load->view("single", $data);

	}

	public function iletisim(){

		$this->load->view("iletisim");

	}

}