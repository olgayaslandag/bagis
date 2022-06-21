<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model {

	public function find($where=[]){

		return $this->db->where($where)->get("users")->result();

	}

	public function add($req=[]){

		$this->db->insert("users", $req);
		return $this->db->affected_rows() > 0 ? $this->db->insert_id() : false;

	}

}