<?php
/*
Plugin Name: Digtal Analytix Implementation for Wordpress
Plugin URI: http://martinjoosse.nl
Description: Basic Digital Analytix Implementation for Wordpress.. Work to be done: site search tracking, event tracking. 
Version: 0.1
Author: Martin Joosse
Author URI: http://martinjoosse.nl
License: GPL2
*/
?><?php

// some definition we will use
define( 'PLUGIN_NAME', 'Digtal Analytix Implementation for Wordpress');
define( 'PLUGIN_DIRECTORY', 'digital-analytix-implementation');
define( 'CURRENT_VERSION', '0.1' );

// create custom plugin settings menu
add_action( 'admin_menu', 'da_create_menu' );

//call register settings function
add_action( 'admin_init', 'da_register_settings' );


register_activation_hook(__FILE__, 'da_activate');
register_deactivation_hook(__FILE__, 'da_deactivate');
register_uninstall_hook(__FILE__, 'da_uninstall');

// activating the default values
function da_activate() {
	add_option('digital_analytix_code', 'any_value');
}

// deactivating
function da_deactivate() {
	// needed for proper deletion of every option
	delete_option('digital_analytix_code');
}

// uninstalling
function da_uninstall() {
	# delete all data stored
	delete_option('digital_analytix_code');
}

function da_create_menu() {

	// create new top-level menu
	add_menu_page( 
	__('Digital Analytix'),
	__('Digital Analytix'),
	0,
	PLUGIN_DIRECTORY.'/da_settings_page.php',
	'',
	plugins_url('/images/icon.png', __FILE__));
	
}

function da_register_settings() {
	//register settings
	register_setting( 'da-settings-group', 'digital_analytix_code' );
}

add_filter('template_include','yoursite_template_include',1);

function yoursite_template_include($template) {
	ob_start();
	return $template;
}
add_filter('shutdown','yoursite_shutdown',0);
function yoursite_shutdown() {
	$insert =  get_option('digital_analytix_code');
	$content = ob_get_clean();
	$content = preg_replace('#<body([^>]*)>#i',"<body$1>{$insert}",$content);
	echo $content;
}


?>
