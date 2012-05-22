<?php
class Music extends CI_Model{
	
	var $songs = 'songs';
	
	/**
	 * Return one by id
	 * @param unknown_type $id
	 * @author Baidoc
	 */
	function get_one_by_id($id){
		return $this->db->where('id',$id)->get($this->songs)->row();
	}
	
	/**
	 * Returneaza mai multe songuri
	 * @param unknown_type $limit
	 * @param unknown_type $offset
	 * @param unknown_type $count
	 * @author Baidoc
	 */
	function get_all($limit = FALSE, $offset = FALSE, $count = FALSE){
		if($count){
			$this->db->select('count(id) as number');
			return $this->db->get($this->songs)->row()->number;
		}
		
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get($this->songs)->result();
	}
	
	/**
	 * Adauga o melodie 
	 * @param unknown_type $title
	 * @param unknown_type $src
	 * @author Baidoc
	 */
	function add($title,$src){
		$data = array(
			'title'	=> $title,
			'src'	=> $src
		);
		
		$this->db->insert($this->songs,$data);
	}
	
	/**
	 * Updateaza o melodie
	 * @param unknown_type $id
	 * @param unknown_type $data
	 * @author Baidoc
	 */
	function update($id,$data){
		$this->db->where('id',$id)->set($data)->update($this->songs);
	}
	
	/**
	 * Sterge o melodie
	 * @param unknown_type $id
	 * @author Baidoc
	 */
	function delete_one_by_id($id){
		$this->db->where('id',$id)->delete($this->songs);
	}
}