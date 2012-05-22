<?php
class Migrate_controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('migrations');
		
		$this->output->enable_profiler();

		$this->migrations->set_verbose(TRUE);

		/** VERY IMPORTANT - only turn this on when you need it. */		
		$access_key = $this->input->get('key');
		if( $access_key != $this->config->item('auth') ){
			show_error('Access restricted');
		}
	}

	// Install up to the most up-to-date version.
	function install($main = TRUE)
	{
		if ( ! $this->migrations->install($main))
		{
			show_error($this->migrations->error);
			exit;
		}

		echo "<br />Migration Successful<br />";
	}

	// This will migrate up to the configed migration version
	function version($id = NULL,$main = TRUE)
	{
		// No $id supplied? Use the config version
		$id OR $id = $this->config->item('migrations_version');

		if ( ! $this->migrations->version($id,$main))
		{
			show_error($this->migrations->error);
			exit;
		}

		echo "<br />Migration Successful<br />";
	}
}
