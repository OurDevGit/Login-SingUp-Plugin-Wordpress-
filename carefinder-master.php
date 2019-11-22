<?php
/**
 * Plugin Name:     Carefinder Api Master
 * Description:     All custom api code stays here!
 * Author:          Carefinder
 * Text Domain:     carefinder
 * Domain Path:     /languages
 * Version:         0.1                                                                                             .0
 *
 */

use Cf\Jwtauth;
use Cf\Posttypes;

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(file_exists(dirname( __FILE__ ).'/vendor/autoload.php')){
	require_once dirname( __FILE__ ).'/vendor/autoload.php';
}

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('Cfmain') ) :


class Cfmain {

	var $version = '1.0';

	var $settings = array();

	var $data = array();

	function run_jwt_auth()
	{
		$plugin = new Cf\Jwtauth();
		$plugin->run();
	}
	function __construct() { 
		register_activation_hook(__FILE__, array($this, 'cf_posttype_role'));
		add_action( 'admin_enqueue_scripts', array($this, 'cf_load_scripts' ) );
		
	}
	function cf_load_scripts(){
		wp_enqueue_script( 'cf_admin_script', CF_URL . 'assets/admin-script.js', array(), '1.0' );
		$obj = array(
			'ajax_url' => admin_url(),
		);
		wp_localize_script( 'cf_admin_script', 'cf', $obj );
	}

	function initialize() {
		
		// vars
		$version = $this->version;
		$basename = plugin_basename( __FILE__ );
		$path = plugin_dir_path( __FILE__ );
		$url = plugin_dir_url( __FILE__ );
		$slug = dirname($basename);
		
		// constants
		$this->define( 'CF', 			true );
		$this->define( 'CF_VERSION', 	$version );
		$this->define( 'CF_PATH', 		$path );
		$this->define( 'CF_URL', 		$url );
		$this->define( 'CF_CURR', 		"$" );
		
		// Include utility functions.
		include_once( CF_PATH . 'includes/cf-user-routes-class.php');

		// $posttypes = new Posttypes();
		if( is_admin() ) {
			// include_once( CF_PATH . 'includes/cf-admin-functions.php');
		}
		
		// actions
		add_action('init',	array($this, 'init'), 5);
		
	}
	public function init(){
		
	}
	function define( $name, $value = true ) {
		if( !defined($name) ) {
			define( $name, $value );
		}
	}
}
function cf() {
	global $cf;
	if( !isset($cf) ) {
		$cf = new Cfmain();
		$cf->initialize();
	}
	return $cf;
}
cf();
endif; 
