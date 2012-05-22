<?php

Class Supported_languages extends CI_Model{
	
	/**
	 * Returneaza lista cu limbi suportate
	 * @return unknown_type
	 */
	function get_supported_languages() {
		$query = $this->db->get('supported_languages')->result();
		return $query;
	}
}