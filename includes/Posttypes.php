<?php

namespace Cf;

if( ! defined( 'ABSPATH' ) ) exit; 

if( ! class_exists('Posttypes') ) :

class Posttypes {
	
	function __construct() {
      $this->register_post_types_events();
  }
 
	function register_post_types_events() {
   
    $args = array(
      'public' => true,
      'show_in_rest' => true,
      'publicly_queryable' => false,
      'label' => 'Event',
      'labels' => array( 
          'name'               => _x( 'Events', 'post type general name', 'kilovision' ),
          'singular_name'      => _x( 'Event', 'post type singular name', 'kilovision' ),
          'menu_name'          => _x( 'Events', 'admin menu', 'kilovision' ),
          'name_admin_bar'     => _x( 'Event', 'add new on admin bar', 'kilovision' ),
          'add_new'            => _x( 'Add New', 'Event', 'kilovision' ),
          'add_new_item'       => __( 'Add New Event', 'kilovision' ),
          'new_item'           => __( 'New Event', 'kilovision' ),
          'edit_item'          => __( 'Edit Event', 'kilovision' ),
          'view_item'          => __( 'View Event', 'kilovision' ),
          'all_items'          => __( 'All Events', 'kilovision' ),
          'search_items'       => __( 'Search Events', 'kilovision' ),
          'parent_item_colon'  => __( 'Parent Events:', 'kilovision' ),
          'not_found'          => __( 'No events found.', 'kilovision' ),
          'not_found_in_trash' => __( 'No events found in Trash.', 'kilovision' )
      ),
      'supports' => array('title', 'custom-fields', 'thumbnail','editor'),
      'menu_icon' => 'dashicons-megaphone'
    );
    register_post_type( 'event', $args );
  }
}

// $newPostTypes = new Postztypes();

endif; 

