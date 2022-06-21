<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bagis extends CI_Controller{

	public function __construct(){

		parent::__construct();
		$this->load->model("QR_Model");

	}

	public function index($qr=null){

		if($qr){

			$qrVeri = $this->QR_Model->find(["qr_code" => $qr]);
			if($qrVeri){

				$this->load->model("Firmalar_Model");
				$firmalar = $this->Firmalar_Model->getAll();

				if($qrVeri[0]->qr_status){

					$data = [
						"result" => (Object) [
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

				$data = [
					"result"=> (Object) [
							"qr" => null,
							"firmalar" => [],
						],
					"status" => false,
					"message"=> "Geçersiz QR bilgisi gönderdiniz!",
				];

			}

		} else {

			$data = [
				"result"=> (Object) [
						"qr" => null,
						"firmalar" => [],
					],
				"status" => false,
				"message"=> "Geçersiz QR bilgisi gönderdiniz!",
			];

		}
		
		$this->load->view("bagisForm", $data);

	}
	
	public function sertifika($qr=null){

		$qr_data = $this->QR_Model->find(["qr_code" => $qr]);
		$qr_id = $qr_data ? $qr_data[0]->qr_id : null;

		$this->load->model("Instruction_Model");
		$instruction = $this->Instruction_Model->getCertificateInfo(["instruction_qr" => $qr_id]);


		$data = [
			"status" => $instruction ? true : false,
			"message"=> $instruction ? null : "Bağış bulunamadı!",
			"result" => $instruction ? (Object)[
				"resim" => base_url("Resim/get/".$instruction->corp_id."/".$instruction->user_adsoyad),
				"instruction" => $instruction,
			] : null,
		];

		$this->load->view("sertifika", $data);

	}

}