<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/* SVN FILE: $Id: MY_Config.php 189 2009-06-04 09:11:38Z Roland $ */
/**
|------------------------------------------------------------------------
| Extension of Code Igniter Config Class
|
| This class supports the automatic inclusion of the language code 
| as an URI segment starting with 'l_' and appends any #anchors in 
| the URI at the very end.
| 
| @package    CodeIgniter
| @subpackage Libraries
| @category	  I18N
| @copyright  Copyright (C) 2008 Roland Blochberger
| @author     Roland Blochberger
|
| This library is free software; you can redistribute it and/or
| modify it under the terms of the GNU Lesser General Public
| License as published by the Free Software Foundation; either
| version 2.1 of the License, or (at your option) any later version.
| 
| This library is distributed in the hope that it will be useful,
| but WITHOUT ANY WARRANTY; without even the implied warranty of
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
| Lesser General Public License for more details.
| 
| You should have received a copy of the GNU Lesser General Public
| License along with this library; if not, write to the Free Software
| Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
|
*/
// Config Version
define('CONFIG_VERSION',    '1.0.1');

class MY_Config extends CI_Config
{
	/**
	 * Constructor
	 *
	 * @access  public
	 */ 
	 function __construct()
	{
		parent::__construct();
		log_message('debug', __CLASS__ . " class ".CONFIG_VERSION." initialized");
	}
    
	// --------------------------------------------------------------------
    
	/**
	 * Site URL
	 *
	 * @access  public
	 * @param   string	the URI string
	 * @param   string  the ISO language code to add to the url; 
	 *                  set empty to add the currently selected ISO language code;
	 *                  set FALSE to suppress the ISO language code in the url.
	 * @return	string
	 */
	function site_url($uri = '', $lang = '')
	{
		if (is_array($uri))
		{
			$uri = implode('/', $uri);
		}

		
		$_url = $this->slash_item('base_url');
		
		if ($uri == '')
		{
			$_url .= $this->item('index_page');
		
		}
		else
		{
			$_url .= preg_replace("|^/*(.+?)/*$|", "\\1", $uri);			
		}
		//log_message('debug', __CLASS__ . ".site_url($uri,$lang):--> $_url");

		// extract any #anchor
		$_anch = '';
		$_p1 = strrpos($_url,'/');

		if (($_p1 < strlen($_url)) && isset($_url[$_p1+1])&& ($_url[$_p1+1] == '#'))
		{
			// extract anchor
			$_anch = substr($_url,$_p1+1);
			$_url = substr($_url, 0, $_p1);
		}
		
		// remove any old ISO language code if necessary
		$_url = preg_replace(array("|/l_(.+?)$|","|/l_(.+?)/|"), "", $_url);

		$exp = explode('/',$uri,2);
		
		$container = NULL;
		if(sizeof($exp) > 0){
			$container = $exp[0];
		}

		$ignore = ($container && (is_dir($container) || in_array($container, array(PREFORMERS_URL,STUDIOS_URL,AFFILIATES_URL,ADMINS_URL))) && $container !== 'performers')?TRUE:FALSE;
		
		//log_message('debug', __CLASS__ . ".site_url($uri,$lang):--> $_url");
		if ($lang !== FALSE && ! $ignore)
		{
			// use the specified or get the currently selected ISO language code
			$_lang = empty($lang) ? ($this->item('lang_selected') == $this->item('lang_default')? NULL : $this->item('lang_selected') ) : $lang;
			
			if (!empty($_lang))
			{			
				if($_url == $this->item('base_url')){
					$_url = $this->item('base_url').$_lang.'/';
				} else {
					// add ISO language code as URI segment
					@list($base_url,$url) = explode($this->item('base_url'),$_url);
					if($url){
						$_url = $this->item('base_url').$_lang.'/'.$url;
					}	
				}			
			}		
		}

		$suffix = ($this->item('url_suffix') === FALSE) ? '' : $this->item('url_suffix');       
		$_url .= $suffix;
		if ($_anch != '')
		{
			$_url .= '/'.$_anch;
		}
		//log_message('debug', __CLASS__ . ".site_url($uri,$lang):--> $_url");
		return $_url;
	}
}

