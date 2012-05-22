<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Helperi pentru lucrul cu dati.
 * @author Bogdan
 * @date 8/8/2011
 */

if (!function_exists('swap')) {
    /**
     * Interschimba valorile a doua variabile.
     * @author Bogdan
     * @param x
     * @param y
     * @return nothing
     */
    function swap(&$x, &$y) {
        $temp = $x;
        $x = $y;
        $y = $temp;
    }
}

if (!function_exists('years_ago')) {
    /**
     * Returneaza un numar reprezentand anul curent minus un n dat.
     * @author Bogdan
     * @param $n
     * @return integer
     */
    function years_ago($n=0) {
        return ((int) date('Y')) - $n;
    }
}

if (!function_exists('generate_year_list')) {
    /**
     * Returneaza o lista de ani de la $from pana la $to.
     * @author Bogdan
     * @param from
     * @param to
     * @param reversed
     * @return array
     */
    function generate_year_list($from, $to, $reversed = FALSE) {
        $list = array();
        if ($reversed) swap($from, $to);
        if ($from < $to) {
            for ($i = $from; $i <= $to; $i++) {
                array_push($list, $i);
            }
        } else {
            for ($i = $from; $i >= $to; $i--) {
                array_push($list, $i);
            }
        }
        return $list;
    }
}

if (!function_exists('generate_relative_year_list')) {
    /**
     * Returneaza o lista de ani de acum $from ani pana acum $to ani.
     * @author Bogdan
     * @param from
     * @param to
     * @param reversed
     * @return array
     */
    function generate_relative_year_list($from, $to, $reversed = FALSE) {
        return generate_year_list(years_ago($from), 
                                  years_ago($to), $reversed); 
    }
}
