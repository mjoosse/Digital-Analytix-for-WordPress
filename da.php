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
	add_option('country', 'any_value');
	add_option('client', 'any_value');
	add_option('site', 'any_value');	
	add_option('pagename', '_default_');	
	
}

// deactivating
function da_deactivate() {
	// needed for proper deletion of every option
	delete_option('country');
	delete_option('client');
	delete_option('site');
	delete_option('pagename');
}

// uninstalling
function da_uninstall() {
	# delete all data stored
	delete_option('country');
	delete_option('client');
	delete_option('site');
	delete_option('pagename');
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
	register_setting( 'da-settings-group', 'country' );
	register_setting( 'da-settings-group', 'client' );
	register_setting( 'da-settings-group', 'site' );
	register_setting( 'da-settings-group', 'pagename' );
}



function dax_code() { 
	$country = get_option('country');
	$client = get_option('client');
	$site = get_option('site');
	$pagename = get_option('pagename');

	?>
	<!-- Begin CMC v2.0 -->
	<script type="text/javascript">
	// <![CDATA[
	function sitestat(u){var d=document,l=d.location;ns_pixelUrl=u+"&ns__t="+(new Date().getTime());u=ns_pixelUrl+"&ns_c="+((d.characterSet)?d.characterSet:d.defaultCharset)+"&ns_ti="+escape(d.title)+"&ns_jspageurl="+escape(l&&l.href?l.href:d.URL)+"&ns_referrer="+escape(d.referrer);var m=u.lastIndexOf("&");if(u.length>2000&&m>=0){u=u.substring(0,m+1)+"ns_cut="+u.substring(m+1,u.lastIndexOf("=")).substring(0,40)}(d.images)?new Image().src=u:d.write('<'+'p><'+'img src="'+u+'" height="1" width="1" alt="*"'+'><'+'/p>');};
	sitestat("//<?php echo $country ?>.sitestat.com/<?php echo $client ?>/<?php echo $site ?>/s?name=<?php echo $pagename ?>");
	// ]]>
	</script>


	<noscript><p><img src="//<?php echo $country ?>.sitestat.com/<?php echo $client ?>/<?php $site ?>/s?name=<?php echo $pagename ?>" height="1" width="1" alt="*"></p></noscript>
	<!-- End CMC -->
	
<?php 



}


add_filter('wp_footer','dax_code');

?>
