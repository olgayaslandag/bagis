<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{

	private $json;

	public function __construct(){

		parent::__construct();

	}

	private function apiJson(){

		header("Access-Control-Allow-Origin: *");
		$this->output->set_content_type('application/json');
	    $this->output->set_header('Access-Control-Allow-Origin: *');
	    $this->output->set_header('Access-Control-Allow-Methods: GET, OPTIONS');
	    $this->output->set_header('Access-Control-Allow-Methods: Content-Type, Content-Length, Accept-Encoding');
	    $this->json = (Object) json_decode(file_get_contents('php://input'));

	}

	public function index(){

		if($this->session->userdata("login")){
			redirect(base_url("admin"), "refresh");
			die();
		}
		$this->load->view("admin/login");

	}

	public function check(){

		$this->apiJson();
		$this->load->model("AdminUser_Model");

		$json = $this->json;
		if(!$json->eposta || !$json->sifre){

			echo json_encode([
				"status" => false,
				"message"=> "Boş alan bırakılamaz!",
				"result" => $json
			]);

		} else {

			$epostaCheck = $this->AdminUser_Model->userFind(["admin_eposta" => $json->eposta]);
			if(!$epostaCheck){

				echo json_encode([
					"status" => false,
					"message"=> "Bu epostaya sahip kullanıcı bulunamadı!",
					"result" => $json
				]);

			} else {

				$check = $this->AdminUser_Model->userFind(["admin_eposta" => $json->eposta, "admin_sifre" => md5($json->sifre)]);
				if(!$check){

					echo json_encode([
						"status" => false,
						"message"=> "Hatalı bilgilerle giriş yapmaya çalışıyorsunuz!",
						"result" => $json
					]);

				} else {

					foreach($check[0] as $key=>$val){
    					$this->session->set_userdata($key,$val);
    				}
    				$this->session->set_userdata('login', true);

					echo json_encode([
						"status" => true,
						"message"=> "Giriş başarılı",
						"result" => $check[0]
					]);

				}

			}

		}

	}


	public function logout(){

		foreach($this->session->userdata() as $key=>$val){
			$this->session->unset_userdata($key);
		}

		redirect(base_url("admin"), "refresh");

	}

}