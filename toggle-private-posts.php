<?php

namespace Athletics\Toggle_Private_Posts;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Plugin Name: Toggle Private Posts
 * Plugin URI: http://github.com/athletics/toggle-private-posts
 * Description: WP Admin Bar control to toggle private posts in current view.
 * Version: 0.1.0
 * Author: Athletics
 * Author URI: http://athleticsnyc.com
 * Copyright: 2015 Athletics
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/**
 * Add Toggle Node
 *
 * @param object WP_Admin_Bar $wp_admin_bar
 */
add_action( 'admin_bar_menu', __NAMESPACE__ . '\\add_admin_bar_node', 999 );

function add_admin_bar_node( $wp_admin_bar ) {

	if ( ! is_valid_location() ) {
		return;
	}

	$url = current_url();

	$args = array(
		'id'    => 'toggle_private_posts',
		'title' => apply_filters( 'toggle_private_posts/label/hide', 'Hide Private Posts' ),
		'href'  => "{$url}?hide_private",
	);

	if ( isset( $_GET['hide_private'] ) ) {
		$args['title'] = apply_filters( 'toggle_private_posts/label/show', 'Show All Posts' );
		$args['href'] = str_replace( '?hide_private', '', $url );
	}

	$wp_admin_bar->add_node( $args );

}

/**
 * Hide private posts
 *
 * @param object WP_Query $query
 */
add_action( 'pre_get_posts', __NAMESPACE__ . '\\toggle_private' );

function toggle_private( $query ) {

	if ( ! is_valid_location() ) {
		return;
	}

	if ( ! $query->is_main_query() ) {
		return;
	}

	if ( isset( $_GET['hide_private'] ) ) {
		$query->set( 'post_status', 'publish' );
	}

}

/**
 * Should the node be added?
 *
 * @return boolean $valid
 */
function is_valid_location() {

	$valid = true;

	if ( is_admin() ) {
		$valid = false;
	}
	else if ( ! current_user_can( 'read_private_pages' ) ) {
		$valid = false;
	}
	else if ( is_singular() ) {
		$valid = false;
	}

	$valid = apply_filters( 'toggle_private_posts/is_valid_location', $valid );

	return is_bool( $valid ) ? $valid : (bool) $valid;

}


/**
 * Current URL
 *
 * @global object $wp
 * @return string
 */
function current_url() {

	global $wp;
	return trailingslashit( home_url( $wp->request ) );

}