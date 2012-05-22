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
     * Gets all photos assigned to a given performer_id.
     * @param performer_id
     * @return array
     */
    function get_multiple_by_performer_id($performer_id) {
        return $this->db->where('performer_id', $performer_id)
                        ->get($this->photos)
                        ->result();
    }

    ###########
    ### ADD ###
    ###########

    /**
     * Add a photo to the database.
     * @param performer_id
     * @param name_on_disk
     * @param title
     * @param is_paid - daca e platita sau nu
     * @param main_photo - daca e poza principala sau nu
     * @param 
     * @return none
     */
    function add($performer_id, $name_on_disk, $title, $is_paid = 0 , $main_photo = 0 ) {
        $this->db->insert($this->photos, array(
            'performer_id' => $performer_id,
            'name_on_disk' => $name_on_disk,
            'title'        => $title,
            'add_date'     => time(),
        	'is_paid'		=> $is_paid,
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
