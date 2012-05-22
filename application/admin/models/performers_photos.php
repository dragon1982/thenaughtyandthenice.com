<?php
class Performers_photos extends MY_Model {
	private $photos = 'performers_photos';
	private $table = 'performers_photos';
	
	public function __construct() {
		$this->set_table($this->table);
	}
	
	/**
	 * AVAILABLE METHODS:
	 * 
	 *		get_all($filters = FALSE, $count = FALSE, $order = FALSE, $offset = FALSE, $limit = FALSE)
	 *		get_by_id($id)
	 *		get_rand($many = 1)
	 *		save($data)
	 *		delete($id)
	 */
	
    ###########
    ### GET ###
    ###########
    
    /**
     * Gets a photo by a given id.
     * @param photo_id
     * @return array
     */
    function get_one_by_id($photo_id) {
        return $this->db->where('photo_id', $photo_id)
                        ->get($this->photos)
                        ->row();
    }

    /**
     * Gets all photos assigned to a given performer_id.
     * @param performer_id
     * @return array
     */
    function get_multiple_by_performer_id($performer_id, $limit = FALSE, $offset = FALSE) {
        $this->db->where('performer_id', $performer_id)->from($this->photos);
        
        if($limit) {
        	$this->db->limit($limit);
        }     
        if($offset) {
        	$this->db->offset($offset);
        }                 
        
        return $this->db->get()->result();
    }
    
	function count_all_by_performer_id($performer_id) {
        return $this->db->select('count(*) as number')
        				->where('performer_id', $performer_id)
                        ->get($this->photos)
                        ->row()->number;
    }

    ###########
    ### ADD ###
    ###########

    /**
     * Add a photo to the database.
     * @param performer_id
     * @param name_on_disk
     * @param title
     * @param main_photo
     * @return none
     */
    function add($performer_id, $name_on_disk, $title,$main_photo = 0) {
        $this->db->insert($this->photos, array(
            'performer_id' => $performer_id,
            'name_on_disk' => $name_on_disk,
            'title'        => $title,
            'add_date'     => time(),
            'main_photo'	=> $main_photo
        ));
    }
    

    ##############
    ### UPDATE ###
    ##############

    /**
     * Updateaza detaliile unei poze
     * @param photo_id
     * @param title
     * @return none
     */
    function update($photo_id, $data) {
        $this->db->where('photo_id', $photo_id)
                 ->update($this->photos, $data);
    }

    ##############
    ### DELETE ###
    ##############
    
    /**
     * Deletes a photo with a given id.
     * @param photo_id
     * @return none
     */
    function delete_photo_by_id($photo_id) {
        $this->db->delete($this->photos, array('photo_id' => $photo_id));
    }
}
