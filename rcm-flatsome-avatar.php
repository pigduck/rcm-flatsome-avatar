<?php
/*
 * Plugin Name: RCM Flatsome Avatar
 * Plugin URI: https://piglet.me
 * Description: RCM HB001 (HB001)
 * Version: 0.1.0
 * Author: heiblack
 * Author URI: https://piglet.me
 * License:  GPL 3.0
 * Domain Path: /languages
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
*/


add_action( 'wp_enqueue_scripts', function () {
    if ( is_account_page() ) {
        wp_enqueue_script( 'my-account', plugins_url( '/js/my-account.js', __FILE__ ));
    }
} );

//wp ajax action

add_action('wp_ajax_rcm_flatsome_avatar_upload', function ()
{
    $file = $_FILES['rcm_eump_image'];
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    $attachment_id = media_handle_upload( 'rcm_eump_image', 0 );
    $user_id = get_current_user_id();
    if ( is_wp_error( $attachment_id ) ) {
        update_user_meta( $user_id, 'image', $_FILES['image'] . ": " . $attachment_id->get_error_message() );
    } else {
        $old = get_user_meta( $user_id, 'image', true );
        update_user_meta( $user_id, 'image', $attachment_id );
        wp_delete_attachment( $old );
    }
    die();
});

add_action( 'woocommerce_account_content', function () {



    echo "<input type=\"file\" id=\"image\" accept=\"image/*\" style=\"display: none\">";

    echo "<input type=\"button\" id=\"save_image\" style=\"display: none\">";



});




add_filter( 'get_avatar', function ( $avatar, $id_or_email, $size, $default, $alt ) {

    if ( ! is_numeric( $id_or_email ) && is_email( $id_or_email->comment_author_email ) ) {
        $user = get_user_by( 'email', $id_or_email );
        if ( $user ) {
            $id_or_email = $user->ID;
        }
    }

    if( ! is_numeric( $id_or_email ) ) {
        return $avatar;
    }

    $attachment_id  = get_user_meta( $id_or_email, 'image', true );

    if ( ! empty ( $attachment_id  ) ) {
        return wp_get_attachment_image( $attachment_id, [ $size, $size ], false, ['alt' => $alt] );
    }

    return $avatar;
}, 10, 5 );


