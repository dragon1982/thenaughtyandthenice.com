<?php
class Performers_schedules extends CI_Model {
	private $schedules = 'performers_schedules';

    ###########
    ### GET ###
    ###########
    
    /**
     * Gets a performer's schedule by a given id.
     * @param performer_id
     * @return array
     */
    function get($performer_id) {
        return $this->db->where('performer_id', $performer_id)
                        ->get($this->schedules)
                        ->result();
    }

    ###########
    ### ADD ###
    ###########

    /**
     * Add an hour to a performer's schedule.
     * @param performer_id
     * @param day_of_week
     * @param hour
     * @return none
     */
    function add_hour($performer_id, $day_of_week, $hour) {
        $this->db->insert($this->schedules, array(
            'performer_id' => $performer_id,
            'day_of_week'  => $day_of_week,
            'hour'         => $hour
        ));
    }

    ##############
    ### DELETE ###
    ##############
    
    /**
     * Deletes an hour from a performer's schedule.
     * @param performer_id
     * @param day_of_week
     * @param hour
     * @return none
     */
    function delete_hour($performer_id, $day_of_week, $hour) {
        $this->db->delete($this->schedules, array(
            'performer_id' => $performer_id,
            'day_of_week'  => $day_of_week,
            'hour'         => $hour
        ));
    }
}
