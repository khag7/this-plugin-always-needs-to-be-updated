<?php
/*
	Plugin Name: This Plugin Always Needs To Be Updated
	Description: This will always show as an available update. Also, the slug for this plugin has special characters, similar to a WooThemes plugin.
	Author: Kevin Hagerty
	Author URI: https://profiles.wordpress.org/khag7/
	Version: 1.0
*/


add_filter( 'site_transient_update_plugins', function( $transient ){
	
	$plugin_file = plugin_basename( __FILE__ );
	$plugin_data = get_plugin_data( trailingslashit( WP_PLUGIN_DIR ) . $plugin_file );
	
	$transient->response[ $plugin_file ] = (object) array(
		'plugin'      => $plugin_file,
		'slug'        => $plugin_file,
		'new_version' => $plugin_data['Version'] . '.1',
		'package'     => 'https://github.com/khag7/this-plugin-always-needs-to-be-updated/archive/master.zip'
	);
	
	return $transient;
}, 999 );