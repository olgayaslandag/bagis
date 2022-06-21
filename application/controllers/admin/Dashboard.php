<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{

	public function __construct(){

		parent::__construct();
		if(!$this->session->userdata("login")){
			redirect(base_url('admin/login'), "refresh");
		}

	}

	private function getData($yil=null, $ay=null){

		$this->load->model("Instruction_Model");
		$data = $this->Instruction_Model->getData([
			"YEAR(instruction_date)" => $yil,
			"MONTH(instruction_date)" => $ay,
		]);

		return $data;

	}

	public function index($yil=null, $ay=null){

		$yil = $yil ? intval($yil) : intval(date('Y'));
    	$ay = $ay ? intval($ay) : intval(date('m'));

    	$data['ay'] = $ay;
    	$data['yil'] = $yil;
		$data['veri'] = $this->getData($yil, $ay);

		$this->load->view("admin/dashboard", $data);

	}

}