<?php
/**
 * CC BuddyPress Group Home Pages
 *
 * @package   CC BuddyPress Group Home Pages
 * @author    CARES staff
 * @license   GPL-2.0+
 * @copyright 2014 CommmunityCommons.org
 */

/**
 * For a given group, is there a published home page?
 *
 * @since    1.0.0
 */
function ccghp_enabled_for_group( $group_id ) {
	$setting = false;

    $custom_front_query = cc_get_group_home_page_post( $group_id );

    if( $custom_front_query->have_posts() )
		$setting = true;

	return apply_filters('ccghp_enabled_for_group', $setting);
}


/**
 * For a given group, get the group home page post.
 *
 * @since    1.0.0
 */
function cc_get_group_home_page_post( $group_id = null, $status = null ) {
	$group_id = ( $group_id ) ? $group_id : bp_get_current_group_id();

	$args =  array(
       'post_type'   => 'group_home_page',
       'posts_per_page' => '1',
       'post_status' => $status == 'draft' ? array( 'pending', 'draft', 'publish' ) : array( 'publish' ),
       'meta_query'  => array(
                           array(
                            'key'           => 'group_home_page_association',
                            'value'         => $group_id,
                            'compare'       => '=',
                            'type'          => 'NUMERIC'
                            )
                        )
    ); 
    $custom_front_query = new WP_Query( $args );

    return $custom_front_query;
}


////////////////
/**
 * Print Filters For
 *
 * Discover what functions are attached to a given hook in WordPress.
 */
function print_filters_for( $hook = null ) {
    global $wp_filter;

    // Error handling
    if ( !$hook )
        return new WP_Error( 'no_hook_provided', __("You didn't provide a hook.") );
    if ( !isset( $wp_filter[$hook] ) )
        return new WP_Error( 'hook_doesnt_exist', __("$hook doesn't exist.") );

    // Display output
    echo '<details closed>';
    echo "<summary>Hook summary: <code>$hook</code></summary>";
    echo '<pre style="text-align:left; font-size:11px;">';
    print_r( $wp_filter[$hook] );
    echo '</pre>';
    echo '</details>';
}