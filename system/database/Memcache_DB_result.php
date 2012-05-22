<?php
class Memcache_DB_result{
	
	public $memcache;
	
	function row(){
		
		
		if (count($this->memcache) == 0)
		{
			return $this->memcache;
		}
		foreach($this->memcache as $result){
			return $result;			
		}				
	}
	
	function result(){
		return $this->memcache;	
	}
	
	function free_result(){
		return $this->memcache;
	}
}