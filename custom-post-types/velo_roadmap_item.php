<?php

function velo_setup_roadmap_item_type() {
    register_post_type('velo_roadmap_item',
        array(
            'labels'      => array(
                'name'          => __('Roadmap Ziele', 'textdomain'),
                'singular_name' => __('Roadmap Ziel', 'textdomain'),
            ),
            'supports' => array('title', 'editor'),
            'public'      => true,
            'has_archive' => true,
            'menu_icon'=>'dashicons-flag',
        )
    );
} 
add_action( 'init', 'velo_setup_roadmap_item_type' );


function velo_add_roadmap_item_box()
{
    $screens = ['velo_roadmap_item'];
    foreach ($screens as $screen) {
        add_meta_box(
            'velo_roadmap_item_box',           // Unique ID
            'Roadmap-Einstellungen',  // Box title
            'velo_roadmap_item_box_html',  // Content callback, must be of type callable
            $screen                   // Post type
        );
    }
}
add_action('add_meta_boxes', 'velo_add_roadmap_item_box');
 
function velo_roadmap_item_box_html($post)
{
    $reachedValue = get_post_meta($post->ID, '_velo_roadmap_item_reached', true);
    $blogValue = get_post_meta($post->ID, '_velo_roadmap_item_blog', true);
    ?>
    <label for="velo_roadmap_item_reached">Ziel erreicht:</label>
    <input type="checkbox" name='velo_roadmap_item_reached' value="checked" <?php echo $reachedValue?>/><br><br>
    <label for="velo_roadmap_item_reached">Blogartikel:</label><br><br>
    <input type="text" name='velo_roadmap_item_blog' value="<?php echo $blogValue;?>" style='width: 100%;'/>
    <?php
}

function velo_roadmap_item_save_postdata($post_id)
{
    if (array_key_exists('velo_roadmap_item_reached', $_POST)) {
        update_post_meta(
            $post_id,
            '_velo_roadmap_item_reached',
            $_POST['velo_roadmap_item_reached']
        );
    } else {
        update_post_meta(
            $post_id,
            '_velo_roadmap_item_reached',
            ''
        );
    }
    if (array_key_exists('velo_roadmap_item_blog', $_POST)) {
        update_post_meta(
            $post_id,
            '_velo_roadmap_item_blog',
            $_POST['velo_roadmap_item_blog']
        );
    }
}
add_action('save_post', 'velo_roadmap_item_save_postdata');

?>