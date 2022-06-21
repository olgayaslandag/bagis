<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Single_Model extends CI_Model {

	public function get(Array $where){

		return $this->db->where($where)->get("posts")->result();

	}

}