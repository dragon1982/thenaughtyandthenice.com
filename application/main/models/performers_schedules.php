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
    function get_schedule_by_performer_id($performer_id) {
        return $this->db->set_memcache_key('performer_schedule-%s',array($performer_id),300)
        				->where('performer_id', $performer_id)
                        ->get($this->schedules)
                        ->result();
    }
}
