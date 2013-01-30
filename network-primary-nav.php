<?php
/**
 * Network:     true
 * Plugin Name: Network Primary Nav
 * Description: Add primary nav of parent blog to all child blogs
 * Plugin URI:  http://wordpress.stackexchange.com/q/83712
 * Version:     0.1
 * Author:      Marco Godínez
 * Author URI:  http://twitter.com/markotom
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
 
add_filter( 'wp_nav_menu_objects', 'network_primary_nav', 100, 2 );
 
    function network_primary_nav( $menu_items, $args )
    {
      global $blog_id;
      $menu_name = 'primary';

      if ( ( $blog_id > 1 ) && $menu_name == $args->theme_location )
      {
        // to parent blog
        switch_to_blog(1);

        $locations = get_nav_menu_locations();

        // get primary nav of parent blog
        if ( isset( $locations[ $menu_name ] ) )
        {
          $menu       = wp_get_nav_menu_object( $locations[ $menu_name ] );
          $menu_items = wp_get_nav_menu_items( $menu->term_id );
        }

        // to child blog
        restore_current_blog();
      }

      return $menu_items;
        
    }