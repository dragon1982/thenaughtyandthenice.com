<?php
class Performers_photos extends CI_Model {
	private $photos = 'performers_photos';

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
     * Gets all photos assign to a given performer_id.
     * @param performer_id
     * @return array
     */
    function get_multiple_by_performer_id($performer_id, $limit=10, $offset=0 , $count = FALSE) {
        $this->db->where('performer_id', $performer_id);
        
        if( $count ){
        	$this->db->select('count(photo_id) as total');
        	return $this->db->get($this->photos)->row()->total;
        } else {
        	return $this->db->get($this->photos, $limit, $offset)
                      		->result();
        }
    }

    ###########
    ### ADD ###
    ###########

    /**
     * Add a photo to the database.
     * @param performer_id
     * @param name_on_disk
     * @param status
     * @param main - if its the main picture
     * @param is_paid - daca e cu plata sau nu
     * @return none
     */
    function add($performer_id, $name_on_disk, $title, $main = 0, $is_paid = 0) {
        $this->db->insert($this->photos, array(
            'performer_id' 	=> $performer_id,
            'name_on_disk' 	=> $name_on_disk,
            'title'        	=> $title,
        	'main_photo' 	=> $main,
        	'is_paid'		=> $is_paid,
            'add_date'     	=> time()
        ));
    }

    ##############
    ### UPDATE ###
    ##############

    /**
     * Update the title of a given photo.
     * @param photo_id
     * @param title
     * @return none
     */
    function update_photo_title($photo_id, $title) {
        $this->db->where('photo_id', $photo_id)
                 ->update($this->photos, array('title' => $title));
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
