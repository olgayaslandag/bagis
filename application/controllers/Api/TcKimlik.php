<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TcKimlik extends CI_Controller{

	public function __construct(){

		parent::__construct();

		header("Access-Control-Allow-Origin: *");
		$this->output->set_content_type('application/json');
	    $this->output->set_header('Access-Control-Allow-Origin: *');
	    $this->output->set_header('Access-Control-Allow-Methods: GET, OPTIONS');
	    $this->output->set_header('Access-Control-Allow-Methods: Content-Type, Content-Length, Accept-Encoding');
	    $this->json = (Object)json_decode(file_get_contents('php://input'));

	}

	function tcNoDogrulama(){

		$tc_no = $this->json->tc_no;
		// İlk 10 rakamın toplamlarının birler basamağı 11. rakamı verir.
	 
		$ilk = $tc_no[0]+$tc_no[1]+$tc_no[2]+$tc_no[3]+$tc_no[4]+$tc_no[5]+$tc_no[6]+$tc_no[7]+$tc_no[8]+$tc_no[9];
		$ilk = substr($ilk, -1);
		$ilk = $tc_no[10] == $ilk ? true : false;
	    
		//1,3,5,7 ve 9. rakamlarının toplamının 7 katı ile 2,4,6 ve 8 rakamlarının toplamının 9 katının toplamının birler basamağı 10.rakamı verir.

		$iki = (($tc_no[0]+$tc_no[2]+$tc_no[4]+$tc_no[6]+$tc_no[8])*7) + (($tc_no[1]+$tc_no[3]+$tc_no[5]+$tc_no[7])*9);
		$iki = substr($iki, -1);
		$iki = $iki == $tc_no[9] ? true : false;
		
		//1, 3, 5, 7 ve 9. rakamlarının toplamının 8 katı birler basamağı 11. rakamı vermektedir.

		$uc = ($tc_no[0]+$tc_no[2]+$tc_no[4]+$tc_no[6]+$tc_no[8])*8;
		$uc = substr($uc, -1);
		$uc = $uc == $tc_no[10] ? true : false;
		

		if($ilk && $iki && $uc)
			echo json_encode([
				"status" => true,
				"message"=> null,
				"result" => null
			]);
		else
			echo json_encode([
				"status" => false,
				"message"=> "Hatalı TC Kimlik Numarası girdiniz!",
				"result" => null,
			]);
	}
  
}