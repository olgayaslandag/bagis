<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Resim extends CI_Controller{

	public function __construct(){

		parent::__construct();

	}

	public function get($firma_id, $isim){

		$this->load->model("Firmalar_Model");

		$corp = $this->Firmalar_Model->find(["corp_id" => $firma_id]);
		$corp = $corp[0];

		if(!$corp){

			return false;

		} else {

			$this->load->helper("fonksiyon");
			header('Content-Type: image/jpeg');
			$resim_url 	= realpath( "assets/sertifikalar/" . $corp->corp_certificate );
			$font 		= realpath( "assets/fonts/Montserrat/static/Montserrat-Regular.ttf" );
			$font_bold 	= realpath( "assets/fonts/Montserrat/static/Montserrat-Bold.ttf" );
			$normal 	= 16;
			$size  		= 34;
			$buyuk 		= 26;

			$resim 	= imagecreatefromjpeg($resim_url);
			$siyah 	= imagecolorallocate($resim, 0, 0, 0);

			$isim = urldecode($isim);
			$isim = mb_strtolower($isim);
			$explode = explode(" ", $isim);
			$isim = "";
			foreach($explode as $ex){
				$isim .= mb_ucfirst($ex)." ";
			}
			// $isim = ucfirst($isim);

			imagettftext($resim, $size, 0, $corp->corp_left, $corp->corp_top, $siyah, $font_bold, $isim);

			imagejpeg($resim);
			imagedestroy($resim);

		}

	}

}