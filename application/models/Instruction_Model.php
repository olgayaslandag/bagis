<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Instruction_Model extends CI_Model {

	public function add($data=[]){

		$this->db->insert("instructions", $data);
		return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;

	}

	public function get($where=[]){

		return $this->db->where($where)->get("instructions")->result();

	}

	public function getCertificateInfo($where=[]){

		$data = $this->db
		->where($where)
		->join("users", "users.user_id=instructions.instruction_user")
		->join("corps", "corps.corp_id=instructions.instruction_corp")
		->get("instructions")
		->result();

		return $data ? $data[0] : null;
		
	}

	public function getData($where=[]){

		return $this->db
		->where($where)
		->order_by("instructions.instruction_date", "DESC")
		->join("users", "users.user_id=instructions.instruction_user")
		->join("qr_codes", "qr_codes.qr_id=instructions.instruction_qr")
		->join("instructions_bank", "instructions_bank.ib_instruction=instructions.instruction_id", "LEFT")
		->join("corps", "corps.corp_id=instructions.instruction_corp")
		->get("instructions")
		->result();

	}

}