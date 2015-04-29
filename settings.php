<?php

add_action( 'admin_menu', 'register_my_custom_menu_page' );

function register_my_custom_menu_page(){
    add_menu_page( 'CRM Integration', 'CRM Integration', 'manage_options', 'crm_integration', 'crm_integration_page', null, 6 );
}

function crm_integration_page(){

    if (isset($_POST['submit'])) {
        crm_process_submission($_POST['api_url'], $_POST['api_name'], $_POST['api_email'], $_POST['api_status'], $_POST['id']);
    }

    include_once 'page.php';
}

function crm_process_submission($url, $name, $email, $status, $id) {

    update_option('api_field_url', strip_tags($url));
    update_option('api_field_id', strip_tags($id));
    update_option('api_field_name', strip_tags($name));
    update_option('api_field_email', strip_tags($email));
    update_option('api_field_status', strip_tags($status));

    //crm_proceed_export();
}

function crm_proceed_export() {

    $pages = get_pages(array('post_type' => 'page'));

    foreach ($pages as $page) {

        crm_send_request($page->ID, $page->post_title, $page->post_content);
    }
}

function crm_send_request($postId, $title, $content) {

    $id = get_option('api_field_id');
    $name = get_option('api_field_name');
    $email = get_option('api_field_email');
    $status = get_option('api_field_status');
    $url =  get_option('api_field_url');

    $data = [];
    $data[$id] = $postId;
    $data['title'] = $title;
    $data['content'] = $content;
    $data[$name] = crm_fields_get_page_meta($postId, 'crm_fields_crm_fields_name');
    $data[$email] = crm_fields_get_page_meta($postId, 'crm_fields_crm_fields_email');
    $data[$status] = crm_fields_get_page_meta($postId, 'crm_fields_crm_fields_status');

    return crm_do_curl($url, $data);
}

function crm_do_curl($url, array $data) {

    $postData = '';

    foreach($data as $k => $v)
    {
        $postData .= $k . '='.$v.'&';
    }

    rtrim($postData, '&');

    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $output = curl_exec($ch);

    curl_close($ch);

    return $output;
}

function crm_fields_get_page_meta($id, $value ) {

    $field = get_post_meta( $id, $value, true );

    if ( ! empty( $field ) ) {
        return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
    } else {
        return false;
    }
}

function crm_save_trigger( $post_id ) {

    // If this is just a revision, don't send the email.
    if ( wp_is_post_revision( $post_id ) )
        return;

    $post = get_post($post_id);

    if ($post->post_type == 'page') {
        return crm_send_request($post_id, $post->post_title, $post->post_content);
    }
}

add_action( 'save_post', 'crm_save_trigger' );
