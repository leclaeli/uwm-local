<?php
require_once( get_stylesheet_directory() . '/custom-posts.php' );
require_once( get_stylesheet_directory() . '/getajaxposts.php' );
require_once( get_stylesheet_directory() . '/getajaxposts-search.php' );

// Add class to body on cpt pages

// add category nicenames in body and post class
function add_sidebar_class( $classes ) {
    global $post;
    if (is_singular('cpt_speakers') || is_singular('cpt_topics' )) {
  // show adv. #1
        $classes[] = "sidebar-primary";
        return $classes;
} else {
  // show adv. #2
    $classes[] = '';
    return $classes;
}
}
add_filter( 'body_class', 'add_sidebar_class' );

/* Count the number of views each post gets*/

function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

/* Set Cookie for one month that will prevent page refreshes from counting towards post views*/

function set_new_cookie() {
    //setting your cookies there
    setcookie("TestCookie", "popular_post_counter", time()+3600*24*30);
}
add_action('init', 'set_new_cookie');


/*
*  Loop through post objects (assuming this is a multi-select field) ( setup postdata )
*  Using this method, you can use all the normal WP functions as the $post object is 
*  temporarily initialized within the loop
*  Read more: http://codex.wordpress.org/Template_Tags/get_posts#Reset_after_Postlists_with_offset
*/
function display_topics($separator = "")
{
    global $post;
    $post_objects = get_field('topics');
    $i=0;
    if($post_objects):

        echo '<ul>';
        foreach($post_objects as $post): // variable must be called $post (IMPORTANT)
            setup_postdata($post);
            $my_permalink = get_permalink();
            echo "<li><a href=" . esc_url($my_permalink) . ">";
            $my_title = get_the_title();
            if ($i>0) {
                echo $separator . $my_title;
            } else {
                echo $my_title;
            }
            echo "</a></li>";
            $i++;
        endforeach;
        echo '</ul>';
        wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly
    endif;
}


/**
 * Enqueue a script.
 */
function custom_js_script()
{
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery'), false, false);
    wp_enqueue_script('jquery-ui-selectable');
    wp_enqueue_style('plugin_name-admin-ui-css',
        'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/smoothness/jquery-ui.css',
        false,
        false,
        false
    );
}
add_action('wp_enqueue_scripts', 'custom_js_script');


/* Add custom post types to taxonomy pages */

function add_custom_types_to_tax( $query ) {
if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {

// Get all your post types
$post_types = get_post_types();

$query->set( 'post_type', $post_types );
return $query;
}
}
add_filter( 'pre_get_posts', 'add_custom_types_to_tax' );
