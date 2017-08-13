<?php
/**
 * Plugin Name: Crisp Grid
 * Description: A responsive post grid plugin to display posts in a grid.
 * Plugin URI: https://www.crispthemes.com/crispgrid-free-wordpress-post-grid-plugin/
 * Author: Crisp Themes
 * Author URI: https://www.crispthemes.com/
 * Version: 1.0
 * Text Domain: crispgrid
 * License: GPL3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License, version 3, as
 published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Get some constants ready for paths when your plugin grows 
 * 
 */

define( 'CRISPGRID_VERSION', '1.0' );
define( 'CRISPGRID_PATH', dirname( __FILE__ ) );
define( 'CRISPGRID_PATH_INCLUDES', dirname( __FILE__ ) . '/inc' );
define( 'CRISPGRID_FOLDER', basename( CRISPGRID_PATH ) );
define( 'CRISPGRID_URL', plugins_url() . '/' . CRISPGRID_FOLDER );
define( 'CRISPGRID_URL_INCLUDES', CRISPGRID_URL . '/inc' );


/**
 * 
 * The plugin base class - the root of all WP goods!
 * 
 * @author WP Designs
 *
 */
class Crispgrid_Plugin_Base {
	
	/**
	 * 
	 * Assign everything as a call from within the constructor
	 */
	public function __construct() {
		// add scripts and styles for frontend
		add_action( 'wp_enqueue_scripts', array( $this, 'crispgrid_add_JS' ) );

		// add scripts and styles only available in admin
		add_action( 'admin_enqueue_scripts', array( $this, 'crispgrid_add_admin_JS' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'crispgrid_add_admin_CSS' ) );
		
		// Register init
		add_action( 'init', array( $this, 'crispgrid_post_type' ), 5 );
		add_action( 'init', array( $this, 'crispgrid_metabox' ), 5 );
		
		// Register activation and deactivation hooks
		register_activation_hook( __FILE__, 'crispgrid_on_activate_callback' );
		register_deactivation_hook( __FILE__, 'crispgrid_on_deactivate_callback' );
		
		// Translation-ready
		add_action( 'plugins_loaded', array( $this, 'crispgrid_add_textdomain' ) );
		
		// Add the shortcode
		add_action( 'init', array( $this, 'crispgrid_shortcode' ) );
	}
	
	/**
	 *
	 * Adding JavaScript scripts for the admin pages only
	 *
	 * Loading existing scripts from wp-includes or adding custom ones
	 *
	 */

	public function crispgrid_add_JS() {
		wp_register_script( 'crispgrid-script', plugins_url( '/js/crispgrid-script.js' , __FILE__ ), array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'crispgrid-script' );
	}

	public function crispgrid_add_admin_JS( $hook ) {
		$screen = get_current_screen();
	    if ( $screen->post_type == 'crispgrid' ) {
	    	wp_enqueue_script( 'iris' );
			wp_register_script( 'crispgrid-script-admin', plugins_url( '/js/admin/crispgrid-script-admin.js' , __FILE__ ), array('jquery'), '1.0', true );
			wp_enqueue_script( 'crispgrid-script-admin' );
		}
	}
	
	/**
	 *
	 * Add admin CSS styles - available only on admin
	 *
	 */
	public function crispgrid_add_admin_CSS( $hook ) {
		$screen = get_current_screen();
	    if ( $screen->post_type == 'crispgrid' ) {
	    	wp_register_style( 'crispgrid-style-admin', plugins_url( '/css/admin/crispgrid-style-admin.css', __FILE__ ), array(), '1.0', 'screen' );
			wp_enqueue_style( 'crispgrid-style-admin' );
		}
	}

	/**
	 * Register Grid CPT
     *
	 */
	public function crispgrid_post_type() {
		register_post_type( 'crispgrid', array(
			'labels' => array(
				'name' => __("Grids", 'crispgrid'),
				'singular_name' => __("Grid", 'crispgrid'),
				'add_new' => _x("Add New", 'crispgrid', 'crispgrid' ),
				'add_new_item' => __("Add New Grid", 'crispgrid' ),
				'edit_item' => __("Edit Grid", 'crispgrid' ),
				'new_item' => __("New Grid", 'crispgrid' ),
				'view_item' => __("View Grid", 'crispgrid' ),
				'search_items' => __("Search Grid", 'crispgrid' ),
				'not_found' =>  __("No grid found", 'crispgrid' ),
				'not_found_in_trash' => __("No grid found in Trash", 'crispgrid' ),
			),
			'public' => false,
			'publicly_queryable' => true,
			'query_var' => true,
			'rewrite' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => false,
			'has_archive' => false,
			'menu_position' => 25,
			'supports' => array(
				'title'
			)
		));	
	}
	
	/**
	 * 
	 *  Grid Settings MetaBoxes
	 *   
	 */
	public function crispgrid_metabox() {
		include_once CRISPGRID_PATH_INCLUDES . '/crispgrid-metabox.php';
	}
	
	
	/**
	 * Register the shortcode for slider
	 * 
	 */
	public function crispgrid_shortcode() {
		include_once CRISPGRID_PATH_INCLUDES . '/crispgrid-shortcode.php';
	}
	
	/**
	 * Add textdomain for plugin
	 */
	public function crispgrid_add_textdomain() {
		load_plugin_textdomain( 'crispgrid', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}	
}


/**
 * Register activation hook
 *
 */
function crispgrid_on_activate_callback() {
	// do something on activation
}

/**
 * Register deactivation hook
 *
 */
function crispgrid_on_deactivate_callback() {
	// do something when deactivated
}

// Initialize everything
$crispgrid_plugin_base = new Crispgrid_Plugin_Base();
