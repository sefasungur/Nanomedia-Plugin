<?php

/*
*		Plugin Name: Nanomedya
*		Plugin URI: https://www.nanomedya.com.tr
*		Description: Nanomedya Eklentisi
*		Version: 1.0.0
*		Author: Sefa Sungur
*		Developer: Nanomedya
*		Developer URI:  https://www.nanomedya.com.tr
*		Text Domain: nanomedya-plugin
*       Copyright: ©2021 Nanomedya
*		Support: https://www.nanomedya.com.tr/tr/contact/
*		Licence: GNU General Public License v3.0
*       License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

add_action( 'admin_enqueue_scripts', 'nanomedyaDashboard');

function nanomedyaDashboard() {
    wp_enqueue_style( 'nanomedya-style', plugin_dir_url( __FILE__ ). '/styles/admin/dashboard.css' );
}

function wp_get_attachment( $attachment_id ) {

    $attachment = get_post( $attachment_id );
    return array(
        'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        'caption' => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href' => get_permalink( $attachment->ID ),
        'src' => $attachment->guid,
        'title' => $attachment->post_title
    );
}


function getPageGallery(){
    /* Hide Gallery Block*/
    wp_enqueue_style( 'hide-gallery-block', plugin_dir_url( __FILE__ ) . 'styles/remove-gallery-block.css' );

    global $post;
    if (has_block('gallery', $post->post_content)) {
        $post_blocks = parse_blocks($post->post_content);
        $ids = @$post_blocks[0][attrs][ids];

    } else {
        return false;
    }
    $images = [];
    foreach($ids as $id ) {
        $dimage = [];
        $image = wp_get_attachment_image_src( $id, "full" );

        $dimage["src"] = $image[0];
        $dimage["width"] = $image[1];
        $dimage["height"] = $image[2];
        $dimage["caption"] = wp_get_attachment_caption($id);
        $dimage["description"] = wp_get_attachment($id);
        $images[] = $dimage;
    }

    return $images;
}

function nano_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo plugin_dir_url( __FILE__); ?>/images/logo.png);
			height:80px;
			width:320px;
			background-size: 320px 80px;
			background-repeat: no-repeat;
        	padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'nano_logo' );
