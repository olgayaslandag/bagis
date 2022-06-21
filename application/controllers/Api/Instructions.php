<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Instructions extends CI_Controller{
	
	public $json;

	public function __construct(){

		parent::__construct();
		date_default_timezone_set('Europe/Istanbul');

		header("Access-Control-Allow-Origin: *");
		$this->output->set_content_type('application/json');
	    $this->output->set_header('Access-Control-Allow-Origin: *');
	    $this->output->set_header('Access-Control-Allow-Methods: GET, OPTIONS');
	    $this->output->set_header('Access-Control-Allow-Methods: Content-Type, Content-Length, Accept-Encoding');
	    $this->json = (Object)json_decode(file_get_contents('php://input'));
		
	}

	private function email_config(){

		$config['protocol']  = 'smtp';
		$config['smtp_host'] = 'biancastella.com.tr';
		$config['smtp_user'] = 'noreply@biancastella.com.tr';
		$config['smtp_pass'] = 'NoBianca12345.';
		$config['smtp_port'] = 465;
		$config["smtp_crypto"] = "ssl";
		$config['charset'] = "utf-8";
		$config['mailtype'] = "html";
		$config['wordwrap'] = true;
		$config['newline'] = "\r\n";

		return $config;

	}

	private function getEmailContent($qr_id){

		$this->load->model("Instruction_Model");
		$instruction = $this->Instruction_Model->getCertificateInfo(["instruction_qr" => $qr_id]);


		$data = [
			"resim" => base_url("Resim/get/".$instruction->corp_id."/".urlencode($instruction->user_adsoyad)),
			"email" => $instruction->user_eposta
		];

		return $data;

	}

	private function getImage($firma_id, $isim, $time){

		$this->load->model("Firmalar_Model");

		$corp = $this->Firmalar_Model->find(["corp_crypt_id" => $firma_id]);
		$corp = $corp[0];

		if(!$corp){

			return false;

		} else {

			$this->load->helper("fonksiyon");
			$resim_url 	= realpath( "assets/sertifikalar/" . $corp->corp_certificate );
			$font 		= realpath( "assets/fonts/Montserrat/static/Montserrat-Regular.ttf" );
			$font_bold 	= realpath( "assets/fonts/Montserrat/static/Montserrat-Bold.ttf" );
			$normal 	= 16;
			$size  		= 34;
			$buyuk 		= 26;

			$resim 	= imagecreatefromjpeg($resim_url);
			$siyah 	= imagecolorallocate($resim, 0, 0, 0);

			$isim = str_replace("%20", " ", $isim);
			$isim = mb_strtolower($isim);
			$explode = explode(" ", $isim);
			$isim = "";
			foreach($explode as $ex){
				$isim .= mb_ucfirst($ex)." ";
			}
			// $isim = ucfirst($isim);

			imagettftext($resim, $size, 0, $corp->corp_left, $corp->corp_top, $siyah, $font_bold, $isim);

			$hedef = "./uploads/sertifikalar/".$time.".jpg";
			imagejpeg($resim, $hedef, 30);
			imagedestroy($resim);
			return $hedef;

		}

	}

	private function email($data=[]){

		$this->load->library('email');
		$this->email->initialize($this->email_config());

		$this->email->from('noreply@biancastella.com.tr', 'Bianca Bağış Sertifikanız');
		$this->email->to($data["email"]);

		$this->email->attach($data["dosya"], "attachment", "sertifika.jpg");
		$this->email->subject('Bianca Bağış Sertifikanız');
		$this->email->message('Merhaba, <br />
			Stella Boya ile evinizde yarattığınız dönüşüm sizin adınıza yaptığımız bağış ile  mutluluğa dönüştür. Tercih ettiğiniz sivil toplum kuruluşunun adınıza özel bağış sertifikasını ekte bulabilirsiniz. <br/><br />
			Daha fazla kişiye ulaşarak yardımlaşmanın mutluluğunu arttırabilmemiz için  sertifikayı sosyal medyada paylaşarak @biancaboya sayfasını etiketlemenizi rica ederiz. <br /><br/>
			Sağlıklı günler dileriz. <br /> <br /> <img src="https://bianca.com.tr/wp-content/themes/bianca/images/logo.png" style="height: 50px;"><br><br>');

		return $this->email->send() ? true : false;

	}

	public function add(){

		$json = $this->json;
		if(!$json){

			echo json_encode([
				"status" => false,
				"message"=> "Herhangi bir veri göndermediniz!",
				"result" => null,
			]);

		} else {

			if(!isset($json->user_adsoyad) || !isset($json->user_eposta) || !isset($json->user_tel) || !isset($json->user_tc) || !isset($json->qr) || !isset($json->qrId) || !isset($json->instruction_corp)){

				echo json_encode([
					"status" => false,
					"message"=> "Eksik bir veri göndermediniz!",
					"result" => null,
				]);

			} else {

				if(!$json->user_adsoyad || !$json->user_eposta || !$json->user_tel || !$json->user_tc || !$json->qr || !$json->qrId || !$json->instruction_corp){

					echo json_encode([
						"status" => false,
						"message"=> "Boş veri gönderemezsiniz!",
						"result" => null,
					]);

				} else {

					base_url("Resim/get/".$json->instruction_corp."/".$json->user_adsoyad);

					$this->load->model("QR_Model");
					$this->load->model("User_Model");

					$bul = $this->QR_Model->find(["qr_id" => $json->qrId]);
					if($bul){

						if($bul[0]->qr_status != 0){

							echo json_encode([
								"status" => false,
								"message"=> "Bu QR ile daha önce işlem yapılmış!",
								"result" => $bul,
							]);

						} else {

							$user_id = $this->User_Model->add([
								"user_adsoyad" => $json->user_adsoyad,
								"user_eposta"  => $json->user_eposta,
								"user_tel" 	   => $json->user_tel,
								"user_tc" 	   => $json->user_tc,
							]);

							$this->load->model("Instruction_Model");

							$bagisVarmi = $this->Instruction_Model->get(["instruction_qr" => $json->qrId]);
							if($bagisVarmi){

								echo json_encode([
									"status" => false,
									"message"=> "Bu QR daha önce tanıtıldı! Lütfen başka bir ürün etiketi satın alın!",
									"result" => $this->json
								]);

							} else {

								$request = [
									"instruction_user" => $user_id,
									"instruction_corp" => $json->instruction_corp,
									"instruction_qr"   => $json->qrId,
									"instruction_ip"   => $json->ip,
								];
								$this->Instruction_Model->add($request);
								$this->QR_Model->update(["qr_id" => $json->qrId], ["qr_status" => 1]);
								




								$time 	= time();
								$dosya = $this->getImage(md5($json->instruction_corp), $json->user_adsoyad, $time);

								$emailSend = $this->email([
									"email" => $json->user_eposta, 
									"image" => './uploads/sertifikalar/'.$time.".jpg",
									"corp"  => $json->instruction_corp,
									"name"  => $json->user_adsoyad,
									"dosya" => $dosya
								]);

								if($emailSend){

									echo json_encode([
										"status" => true,
										"message"=> "Bağışınız başarılı bir şekilde gerçekleştirildi.",
										"result" => $json,
									]);

								} else {

									echo json_encode([
										"status" => true,
										"message"=> "Bağışınız gerçekleştirildi fakat e-posta iletilemedi!",
										"result" => $json,
									]);

								}

							}

						}

					} else {

						echo json_encode([
							"status" => true,
							"message"=> "Bu QR sistemde kayıtlı değil!",
							"result" => $this->json,
						]);

					}

				}

			}

		}

	}

}