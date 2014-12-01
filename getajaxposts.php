
<?php
/* Use AJAX to pass data from page to server */

function enqueue_scripts_styles_init() {
    wp_enqueue_script( 'ajax-script', get_stylesheet_directory_uri().'/js/script.js', array('jquery'), false, true ); // jQuery will be included automatically
    // get_template_directory_uri() . '/js/script.js'; // Inside a parent theme
    // get_stylesheet_directory_uri() . '/js/script.js'; // Inside a child theme
    // plugins_url( '/js/script.js', __FILE__ ); // Inside a plugin
    wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); // setting ajaxurl
}
add_action('wp_enqueue_scripts', 'enqueue_scripts_styles_init');

function ajax_action_stuff() {
    
    $post_id = isset($_POST['post_id'])?$_POST['post_id']:0;
    $post_id = substr($post_id, -2);
    $li_index = $_POST['li_index'];
    
    if ( $post_id > 0 )
    {
            $post = get_post($post_id);
        ?>
        <div id='post-<?php echo $post_id ?>' class='<?php echo $li_index ?>'><?php echo $post->post_title; ?></div>
        <?php 
    }
    die();


}
add_action( 'wp_ajax_nopriv_ajax_action', 'ajax_action_stuff' ); // ajax for not logged in users
add_action( 'wp_ajax_ajax_action', 'ajax_action_stuff' ); // ajax for logged in users
?>

