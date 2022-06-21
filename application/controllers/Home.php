<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller{

	public function __construct(){

		parent::__construct();
		$this->load->model("QR_Model");

	}

	public function index($qr=null){

		if($qr){

			$bul = $this->QR_Model->find(["qr_code" => $qr]);
			if($bul){

				if($bul[0]->qr_status){

					$result = [
						"status" => false,
						"message"=> "Gönderdiğiniz QR ile daha önce işlem yapılmış!",
						"result" => $qr,
					];

				} else {

					$result = [
						"status" => true,
						"message"=> "Gönderdiğiniz QR sistemde kayıtlı ve işlem yapılabilir.",
						"result" => $qr,
					];

				}

			} else {

				$result = [
					"status" => false,
					"message"=> "Gönderdiğiniz QR sistemde kayıtlı değil!",
					"result" => $qr,
				];

			} 

		} else {

			$result = [
				"status" => false,
				"message"=> "QR bilgisi göndermediniz!",
				"result" => $qr,
			];

		}

		$this->load->view("home", $result);

	}

	public function qrGenerator(){

		for($i=0; $i<20000; $i++){
			$data = [
				"qr_code" => sifreleme(),
				"qr_status" => 0
			];
			
			if(!$this->QR_Model->find($data)){
				$this->QR_Model->insert($data);
			}
		}
		
	}

}