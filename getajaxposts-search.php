
<?php
/* Use AJAX to pass data from page to server */

function enqueue_ajax_scripts() {
    wp_enqueue_script( 'ajax-script', get_stylesheet_directory_uri().'/js/script.js', array('jquery'), false, true ); // jQuery will be included automatically
    // get_template_directory_uri() . '/js/script.js'; // Inside a parent theme
    // get_stylesheet_directory_uri() . '/js/script.js'; // Inside a child theme
    // plugins_url( '/js/script.js', __FILE__ ); // Inside a plugin
    wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); // setting ajaxurl
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_scripts');

function ajax_action_search() {
    
    $post_id = isset($_POST['post_id'])?$_POST['post_id']:0;
    //$li_index = $_POST['li_index'];
    $test_array = isset($_POST['test_array'])?$_POST['test_array']:null;
    
    
    if ($post_id > 0) {
            $post = get_post($post_id);
        ?>
        <div id='post-<?php echo $post_id ?>' class='<?php echo $li_index ?>'><?php echo $post->post_title; ?></div>
        <?php 
    } ?>

    <div class="inner-results">
 

 <?php 
 // Query arguments

    // $args = array(
    // 'numberposts' => -1,
    // 'post_type' => 'cpt_speakers',
    // 'meta_query' => array(
    //     'relation' => 'OR',
    //     )
    // );

     // if (isset($test_array)) {
     //     foreach($test_array as $value) :
     //         $args['meta_query'][] =array(
     //          'key' => 'acf_topics',
     //          'value' => $value,
     //          'compare' => 'LIKE'
     //         );
     //     endforeach;
     // }

    // GET RECIPES THAT HAVE A RELATIONSHIP TO PRODUCTS ON THE CURRENT PAGE - dynamically


// foreach($test_array as $value) {
//     array_push($args['meta_query'], array(
//         'key' => 'acf_topics',
//         'value' => '"' . $value . '"',
//         'compare' => 'LIKE'
//     ));
// }

// add_filter('posts_join', 'people_join' );

// function people_join($wp_join) {
    
//     global $wpdb;
    
//     if ( is_page( $wpdb )) {
//         global $wpdb;
//         $wp_join .= " LEFT JOIN (
//                 SELECT post_id, meta_value as acf_topics
//                 FROM $wpdb->postmeta
//                 WHERE meta_key =  'acf_topics' ) AS NL
//                 ON $wpdb->posts.ID = NL.post_id ";
//     }
//     return ($wp_join);
// }




// get results
$the_query = new WP_Query( $args );

// The Loop
?>
<?php if( $the_query->have_posts() ): ?>
    <ul>
    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
        <li>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
    
    <?php endwhile; ?>
    <?php else : ?>
            <?php get_template_part( 'content', 'none' ); ?>
    </ul>
<?php endif; ?>

<?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>
        </div> <!-- End widget -->

<?php

    die();


}
add_action( 'wp_ajax_nopriv_ajax_action_search', 'ajax_action_search' ); // ajax for not logged in users
add_action( 'wp_ajax_ajax_action_search', 'ajax_action_search' ); // ajax for logged in users
?>

