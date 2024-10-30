<?php

function pluginCSS($dd){
	// add admin css
	$css_file = get_bloginfo('wpurl').'/wp-content/plugins/'._getDir.'wp_plugin.css';
	echo ('<link rel="stylesheet" type="text/css" href="'.$css_file.'" />');
}

class wp_nplugin{
	public function wp_nplugin(){
		
	}
	
	public function addAdminHeader(){
		if (!defined('_getDir'))
			define('_getDir', $this->getDir());
		add_action('admin_head','pluginCSS');	
	}
	
	public function getDir(){
		$_temp 	= preg_replace('/^.*wp-content[\\\\\/]plugins[\\\\\/]/', '', __FILE__);
		$_temp 	= str_replace(basename(__FILE__), '', $_temp);
		$_temp  = str_replace('\\','/',$_temp);
		return $_temp;
	}
}
?>