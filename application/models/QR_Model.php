<?php defined('BASEPATH') OR exit('No direct script access allowed');

class QR_Model extends CI_Model {

	public function insert($data=[]){

		$this->db->insert("qr_codes", $data);

	}

	public function find($where=[]){

		return $this->db->where($where)->get("qr_codes")->result();

	}

	public function update($where=[], $data=[]){

		$this->db->where($where)->update("qr_codes", $data);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;

	}

}