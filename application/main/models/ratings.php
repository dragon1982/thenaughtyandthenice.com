<?php
class Ratings extends CI_Model {
    private $ratings = 'performers_ratings';

    ###########
    ### GET ###
    ###########

    /**
     * Returns the rating for a given performer_id.
     * @author Bogdan
     * @param performer_id
     * @return int
     */
    function get_performers_rating($performer_id) {
        $result = $this->db->where('performer_id', $performer_id)
                           ->select('rating')
                           ->get($this->ratings)
                           ->result();
        if (count($result) == 0) return -1;
        $rating = 0;
        foreach ($result as $row) {
            $rating += $row->rating;
        }
        return $rating / count($result);
    }

    /**
     * Returns the number of ratings for a given performer_id.
     * @author Bogdan
     * @param performer_id
     * @return int
     */
    function get_performers_rating_count($performer_id) {
        $result = $this->db->where('performer_id', $performer_id)
                           ->select('rating')
                           ->get($this->ratings)
                           ->result();
        return count($result);
    }

    ###########
    ### ADD ###
    ###########

    /**
     * Adds a rating to the database.
     * @author Bogdan
     * @param performer_id
     * @param user_id
     * @param rating
     * @return boolean
     */
    function add($performer_id, $user_id, $rating) {
        $query = $this->db->where(array(
            'performer_id' => $performer_id,
            'user_id'      => $user_id
        ))->get($this->ratings);
        $rated  = $query->result();
        if ($rated) {
            $this->db->where(array(
                'performer_id' => $performer_id,
                'user_id'      => $user_id
            ))->update($this->ratings, array('rating' => $rating));
        } else {
            $this->db->insert($this->ratings, array(
                'performer_id' => $performer_id,
                'user_id'      => $user_id,
                'rating'       => $rating
            ));
        }
        $rating = $this->get_performers_rating($performer_id);
        return $this->db->where('id', $performer_id)
                        ->update('performers', array('rating' => $rating));
    }
}
