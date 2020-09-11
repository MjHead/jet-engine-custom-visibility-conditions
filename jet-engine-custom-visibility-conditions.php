<?php
/**
 * Plugin Name: JetEngine - Custom visibility conditions
 * Plugin URI:
 * Description:
 * Version:     1.0.0
 * Author:      Crocoblock
 * Author URI:  https://crocoblock.com/
 * Text Domain: jet-appointments-booking
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

add_action( 'plugins_loaded', 'jet_engine_cvc' );

function jet_engine_cvc() {

	define( 'JET_ECVC__FILE__', __FILE__ );
	define( 'JET_ECVC_PLUGIN_BASE', plugin_basename( JET_ECVC__FILE__ ) );
	define( 'JET_ECVC_PATH', plugin_dir_path( JET_ECVC__FILE__ ) );

	add_action( 'jet-engine/modules/dynamic-visibility/conditions/register', function( $conditions_manager ) {

		require JET_ECVC_PATH . 'post-status.php';
		require JET_ECVC_PATH . 'post-by-user.php';
		require JET_ECVC_PATH . 'user-meta.php';
		require JET_ECVC_PATH . 'user-meta-is-post-meta.php';

		$conditions_manager->register_condition( new Jet_Engine_CVC\Post_Status() );
		$conditions_manager->register_condition( new Jet_Engine_CVC\Post_By_User() );
		$conditions_manager->register_condition( new Jet_Engine_CVC\User_Meta_Is() );
		$conditions_manager->register_condition( new Jet_Engine_CVC\User_Meta_Is_Post_Meta() );

	} );

}
