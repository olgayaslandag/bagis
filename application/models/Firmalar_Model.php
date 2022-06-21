<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Firmalar_Model extends CI_Model {

	public function getAll(){

		return $this->db->order_by("corp_name", "ASC")->get("corps")->result();

	}

	public function find($where=[]){

		return $this->db->where($where)->get("corps")->result();

	}

}