<?php
/**
 * @property Studios $studios
 * @author Andrei
 *
 */
class Install_controller extends CI_Controller {
    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->populate_studios();       
    }

    /**
     * Generates performer metadata.
     * @author Bogdan
     * @param password
     * @return none
     */
    function generate_studio_metadata($password) {
        $hash 	  = generate_hash('studios');
        $salt 	  = $this->config->item('salt');
        $status   = 'approved';
        $password = hash('sha256', $salt.$hash.$password);
        return array('hash'     => $hash,
                     'salt'     => $salt,
                     'status'   => $status,
                     'password' => $password);
    }

    /**
     * Adds a performer to the database.
     * @author Bogdan
     * @param username
     * @param password
     * @return none
     */
    function add_studio($username, $password) {
        $IP   = '192.168.0.1';
        $meta = $this->generate_studio_metadata($password);

        $pid  = $this->studios->add(	$username, 
                                       $meta['password'],
                                       $meta['hash'],
                                       'foo@bar.baz',
                                       $username, 
                                       $username,
                                       $meta['status'],
                                       time(), 
                                       ip2long($IP),
                                       'approved',
                                       '111 Foo St.',
                                       'Alabama',
                                       'Somewhere-in',
                                       '515200',
                                       '555-555-555',
                                       'RO',
                                       	'1','1','22');
    }

    /**
     * Adds performers to the database.
     * @author Bogdan
     * @return none
     */
    function populate_studios() {
        $this->load->model('studios');
        $this->db->trans_begin();
        echo 'Adding studios:<br/>';
        for ($i = 0; $i < 1000; $i++) {
            $this->add_studio('foo'.$i, 'foo'.$i);
            echo 'added studios foo'.$i.'.<br/>';
        }
        if (!$this->db->trans_status()) {
            $this->db->trans_rollback();
        }
        $this->db->trans_commit();
    }
}