<?php 



if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('kvp_admin') ) :


class kvp_admin extends cf_user_routes{
	
	private $options_general;
	private $roles;
	private $wpdb;
	function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;
		add_action('admin_menu', 			array($this, 'kvp_admin_menu'));
		// add_action( 'admin_init', array( $this, 'kv_options_init' ) );
		add_action( 'login_headerurl', array( $this, 'kv_change_admin_logo_url' ),1,10 );
		add_filter('manage_users_columns',array($this, 'kvp_remove_users_columns' ),11,1);
		add_filter('admin_enqueue_scripts',array($this, 'load_admin_styles' ));
		add_filter('pre_site_transient_update_core',array($this,'remove_core_updates'));
		add_filter('pre_site_transient_update_plugins',array($this,'remove_core_updates'));
		add_filter('pre_site_transient_update_themes',array($this,'remove_core_updates'));
		// add_action( 'rest_api_init' , array($this, 'pricing_register_routes') );
		add_action( 'delete_user', array($this, 'kvp_when_delete_user') );
		
		
		// $this->roles = $this->get_roles();
		add_filter( 'manage_users_custom_column',array($this, 'manage_users_username_section'));
	}	
	
	function manage_users_username_section( $val, $col, $uid ) {
		// if ( 'name' === $col )
		// 	return get_the_author_meta( 'first_name', $uid );
		die();
	}
	function kvp_when_delete_user( $user_id ) {
		global $wpdb;
		$table_name = $wpdb->prefix. 'booking_list';
		$user_obj = get_userdata( $user_id );
		$wpdb->query("DELETE FROM $table_name WHERE user_id=$user_obj->ID");
	}
	
	
	function remove_core_updates(){
		global $wp_version;
		return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
	}

	
	function load_admin_styles(){
		
		wp_enqueue_style( 'admin_setting_styles', plugins_url('assets/dead-simple.css', __DIR__ ), false, '1.0.0' );
	}
	function kvp_remove_users_columns($column){
		// unset($column['username']);
		// unset($column['name']);
		unset($column['posts']);
		// unset($column['username']);
		// $column['DisplayName']
		return $column;
	}
	


	function kv_change_admin_logo_url($url){
		return site_url();
	}
    function kv_change_admin_logo(){
		$logopath = KVP_URL . 'assets/kilo.jpg';
		
		?>
		<style type="text/css"> 
			body.login div#login h1 a {
			background-image: url(<?php echo $logopath; ?>);  //Add your own logo image in this url 
			padding-bottom: 30px; 
			} 
		</style>
		<?php
	}
	function remove_admin_logo() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'wp-logo' );
	}
	
	function kvp_admin_menu() {
		remove_menu_page('edit.php');
		remove_menu_page('edit.php?post_type=page');
		// remove_menu_page('edit.php?post_type=acf-field-group');
		remove_menu_page('themes.php');
		remove_menu_page('edit-comments.php');
		remove_menu_page('plugins.php');
		remove_menu_page('options-general.php');
		remove_menu_page('tools.php');
		// $pending_booking = $this->get_pending_booking();
		// if($pending_booking > 0){
		// 	$booking_text = sprintf("Booking <span class='awaiting-mod pending'>%d</span>",$this->get_pending_booking());
		// }else{
			$booking_text = __("Booking", 'kilovision');
		// }
		// add_menu_page( "Booking" , $booking_text , 'manage_options', 'bookings', array( $this , 'kvp_bookings_template' ), 'dashicons-calendar', 50);
		// add_submenu_page( "bookings" , "Booking Pricing" , "Booking Pricing", 'manage_options', 'pricing', array( $this , 'kvp_role_setting_template' ));


		// add_submenu_page( "bookings" , "Booking slots" , "Booking slots", 'manage_options', 'edit-tags.php?taxonomy=booking_slots');

		add_action( 'wp_before_admin_bar_render', array($this, 'remove_admin_logo'));
		add_filter( 'admin_footer_text', '__return_empty_string', 11 );
		add_filter( 'update_footer',     '__return_empty_string', 11 );

		add_action( 'init', array($this, 'redirect_to_backend' ));

		add_action('admin_bar_menu', array($this, 'kvp_remove_admin_node'), 999);
		add_action('wp_dashboard_setup', array($this, 'remove_dashboard_widgets'));

	}
	function kvp_bookings_template(){

	}
	function remove_dashboard_widgets(){
		remove_meta_box('dashboard_activity', 'dashboard', 'normal');
		remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
		remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
		remove_meta_box('dashboard_primary', 'dashboard', 'side');
		remove_meta_box('welcome_panel', 'dashboard', 'normal');

	}
	function redirect_to_backend() {
		if( !is_admin() ) {
			wp_redirect( site_url('wp-admin') );
			exit();
		}
	}
	function kvp_remove_admin_node($wp_admin_bar) {
		
		$wp_admin_bar->remove_node('view-site');
		$wp_admin_bar->remove_node('comments');
		$wp_admin_bar->remove_node('new-content');
		
	}
	
	function kvp_role_setting_template() {
		
	}
	
}

// initialize
$admin = new kvp_admin();

endif; // class_exists check

?>