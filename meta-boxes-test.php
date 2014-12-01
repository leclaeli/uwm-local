<?php

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function myplugin_add_meta_box() {

    $screens = array( 'post', 'page' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'myplugin_sectionid',
            __( 'My Post Section Title', 'myplugin_textdomain' ),
            'myplugin_meta_box_callback',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'myplugin_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function myplugin_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'myplugin_meta_box', 'myplugin_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $value = get_post_meta($post->ID);

    echo '<label for="myplugin_new_field">';
    _e( 'Description for this field', 'myplugin_textdomain' );
    echo '</label> ';
    //echo '<input type="text" id="myplugin_new_field" name="myplugin_new_field" value="' . esc_attr( $value ) . '" size="25" />';
    //echo $value['myplugin_new_field'][0];

    $args = array(
    'post_type' => 'topics',
    'nopaging'  => true
);

$query = new WP_Query( $args );

//echo '<select name="myplugin_new_field" id="myplugin_new_field">';


//$i = 1;
//while ( $query->have_posts() ) : $query->the_post(); ?>
<label for="meta-checkbox">
<input type="checkbox" name="meta-checkbox" id="meta-checkbox" value="yes" <?php if ( isset ( $value['meta-checkbox'] ) ) checked( $value['meta-checkbox'][0], 'yes' ); ?> />
<?php _e( 'Checkbox label', 'myplugin_textdomain' )?>
</label>
<label for="meta-checkbox-two">
<input type="checkbox" name="meta-checkbox-two" id="meta-checkbox-two" value="yes" <?php if ( isset ( $value['meta-checkbox-two'] ) ) checked( $value['meta-checkbox-two'][0], 'yes' ); ?> />
<?php _e( 'Another checkbox', 'myplugin_textdomain' )?>
</label>
<?php
//$i++;
//endwhile;


/* Restore original Post Data */
//wp_reset_postdata();

}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function myplugin_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'myplugin_meta_box' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */
    
    // Make sure that it is set.
    // Checks for input and saves

// Checks for input and saves
if( isset( $_POST[ 'meta-checkbox' ] ) ) {
update_post_meta( $post_id, 'meta-checkbox', 'yes' );
} else {
update_post_meta( $post_id, 'meta-checkbox', '' );
}
// Checks for input and saves
if( isset( $_POST[ 'meta-checkbox-two' ] ) ) {
update_post_meta( $post_id, 'meta-checkbox-two', 'yes' );
} else {
update_post_meta( $post_id, 'meta-checkbox-two', '' );
}

    // Sanitize user input.
    //$my_data = sanitize_text_field( $_POST['myplugin_new_field'] );

    // Update the meta field in the database.
    //update_post_meta( $post_id, '_my_meta_value_key', $my_data );
}
add_action( 'save_post', 'myplugin_save_meta_box_data' );