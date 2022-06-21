<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AdminUser_Model extends CI_Model {

	public function userFind($where=[]){

		return $this->db->where($where)->get("admins")->result();

	}

}