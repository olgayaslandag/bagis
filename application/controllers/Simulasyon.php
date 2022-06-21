<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Simulasyon extends CI_Controller{

	public function __construct(){

		parent::__construct();
		$this->load->model("QR_Model");

	}

	public function index($qr){

		$qrVeri = $this->QR_Model->find(["qr_code" => $qr]);
		if($qrVeri){

			$this->load->model("Firmalar_Model");
			$firmalar = $this->Firmalar_Model->getAll();

			if($qrVeri[0]->qr_status){

				$data = [
					"result"	 => (Object) [
						"qr" => $qrVeri[0],
						"firmalar" => $firmalar
					],
					"status" => false,
					"message"=> "Bu QR daha önce kullanılmış!",
				];

			} else {

				$data = [
					"result"=> (Object) [
						"qr" => $qrVeri[0],
						"firmalar" => $firmalar,
					],
					"status" => true,
					"message"=> null,
				];

			}

		} else {

			$data = (Object) [
				"result" => null,
				"status" => false,
				"message"=> "Geçersiz QR bilgisi gönderdiniz!",
			];

		}
		// echo json_encode($data);exit;
		$this->load->view("simulasyon", $data);

	}

}