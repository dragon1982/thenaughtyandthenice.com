<?php
/**
 * Genereaza tabelul corespunzator orarului performarilor.
 * @author Bogdan
 * @param performer_id
 * @return string
 */
if ( ! function_exists('render_schedule')) {
	
    function render_schedule($schedules, $as_string = FALSE) {

        $days_of_week = array('M', 'T', 'W', 'T', 'F', 'S', 'S');
        $map          = array();
        for ($i = 0; $i < 7; $i++){
        	
            for ($j = 0; $j < 25; $j++){
                $map[$i][$j] = 0;
            }
            
        }
        
        foreach ($schedules as $schedule){
            $map[$schedule->day_of_week][$schedule->hour] = 1;
        }
        
        return array('days_of_week' => $days_of_week,'map'=> $map);
    }
}
