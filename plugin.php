<?php
/*
	Plugin Name: This Plugin Always Needs To Be Updated
	Description: This will always show as an available update. Also, the slug for this plugin has special characters, similar to a WooThemes plugin.
	Author: Kevin Hagerty
	Author URI: https://profiles.wordpress.org/khag7/
	Version: 1.0
*/

/* 
	
	This plugin is a very primitive example of how a 3rd party plugin might implement automatic updates for their plugin:
	1) It is missing a check to an API for the next available version of the plugin. Instead we are simulating that by pretending their is always an update available.
	2) It uses the update_plugins transient to store the 'package' url of the new plugin file which is avialble for download.
	3) It overrides the plugins_api plugin_information display with custom content.
	
*/


//forcibly add our plugin to the list of avaialble plugin updates
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

//Override the plugins_api -- return true to suprress the normal plugin information iframe content from showing
add_filter( 'plugins_api', function( $false, $action, $args ){
	if ( $action == 'plugin_information' && $args->slug == plugin_basename( __FILE__ ) ) return true;
	return $false;
}, 10, 3 );

//echo whatever content we want to display in the plugin information iframe
add_action( 'install_plugins_pre_plugin-information', function(){
	?>
		<h2>This Plugin Always Needs To Be Updated</h2>
		<a href="https://github.com/khag7/this-plugin-always-needs-to-be-updated/" target="_blank">Available on Github</a>
		<p style="white-space:pre;"><?php echo file_get_contents( 'https://raw.githubusercontent.com/khag7/this-plugin-always-needs-to-be-updated/master/README.md' ); ?></p>
	<?php
});