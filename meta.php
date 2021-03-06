<?php

/**
 * Generated by the WordPress Meta Box generator
 * at http://jeremyhixon.com/wp-tools/meta-box/
 */

function crm_fields_get_meta( $value ) {
    global $post;

    $field = get_post_meta( $post->ID, $value, true );
    if ( ! empty( $field ) ) {
        return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
    } else {
        return false;
    }
}

function crm_fields_add_meta_box() {
    add_meta_box(
        'crm_fields-crm-fields',
        __( 'CRM Fields', 'crm_fields' ),
        'crm_fields_crm_fields_html',
        'page',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'crm_fields_add_meta_box' );

function crm_fields_crm_fields_html( $post) {
    wp_nonce_field( '_crm_fields_crm_fields_nonce', 'crm_fields_crm_fields_nonce' ); ?>

    <p>
        <label for="crm_fields_crm_fields_name"><?php _e( 'Name', 'crm_fields' ); ?></label><br>
        <input type="text" name="crm_fields_crm_fields_name" id="crm_fields_crm_fields_name" value="<?php echo crm_fields_get_meta( 'crm_fields_crm_fields_name' ); ?>">
    </p>    <p>
        <label for="crm_fields_crm_fields_email"><?php _e( 'Email', 'crm_fields' ); ?></label><br>
        <input type="text" name="crm_fields_crm_fields_email" id="crm_fields_crm_fields_email" value="<?php echo crm_fields_get_meta( 'crm_fields_crm_fields_email' ); ?>">
    </p>    <p>
        <label for="crm_fields_crm_fields_status"><?php _e( 'Status', 'crm_fields' ); ?></label><br>
        <select name="crm_fields_crm_fields_status" id="crm_fields_crm_fields_status">
            <option <?php echo (crm_fields_get_meta( 'crm_fields_crm_fields_status' ) === 'single' ) ? 'selected' : '' ?>>single</option>
            <option <?php echo (crm_fields_get_meta( 'crm_fields_crm_fields_status' ) === 'married' ) ? 'selected' : '' ?>>married</option>
            <option <?php echo (crm_fields_get_meta( 'crm_fields_crm_fields_status' ) === 'divorce' ) ? 'selected' : '' ?>>divorce</option>
            <option <?php echo (crm_fields_get_meta( 'crm_fields_crm_fields_status' ) === 'widow' ) ? 'selected' : '' ?>>widow</option>
        </select>
    </p><?php
}

function crm_fields_crm_fields_save( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! isset( $_POST['crm_fields_crm_fields_nonce'] ) || ! wp_verify_nonce( $_POST['crm_fields_crm_fields_nonce'], '_crm_fields_crm_fields_nonce' ) ) return;
    if ( ! current_user_can( 'edit_post' ) ) return;

    if ( isset( $_POST['crm_fields_crm_fields_name'] ) )
        update_post_meta( $post_id, 'crm_fields_crm_fields_name', esc_attr( $_POST['crm_fields_crm_fields_name'] ) );
    if ( isset( $_POST['crm_fields_crm_fields_email'] ) )
        update_post_meta( $post_id, 'crm_fields_crm_fields_email', esc_attr( $_POST['crm_fields_crm_fields_email'] ) );
    if ( isset( $_POST['crm_fields_crm_fields_status'] ) )
        update_post_meta( $post_id, 'crm_fields_crm_fields_status', esc_attr( $_POST['crm_fields_crm_fields_status'] ) );
}
add_action( 'save_post', 'crm_fields_crm_fields_save' );

/*
    Usage: crm_fields_get_meta( 'crm_fields_crm_fields_name' )
    Usage: crm_fields_get_meta( 'crm_fields_crm_fields_email' )
    Usage: crm_fields_get_meta( 'crm_fields_crm_fields_status' )
*/
