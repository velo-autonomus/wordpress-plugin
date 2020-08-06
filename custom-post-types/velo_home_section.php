<?php

function velo_setup_home_section_type() {
    register_post_type('velo_home_section',
        array(
            'labels'      => array(
                'name'          => __('Homepage Sections', 'textdomain'),
                'singular_name' => __('Homepage Section', 'textdomain'),
            ),
            'supports' => array('title', 'thumbnail', 'editor'),
            'public'      => true,
            'has_archive' => true,
            'show_in_rest' => true,
            'menu_icon'=>'dashicons-editor-insertmore',
        )
    );
} 
add_action( 'init', 'velo_setup_home_section_type' );


function velo_add_home_section_type_box()
{
    $screens = ['velo_home_section'];
    foreach ($screens as $screen) {
        add_meta_box(
            'velo_home_section_type_box',           // Unique ID
            'Typ',  // Box title
            'velo_home_section_type_box_html',  // Content callback, must be of type callable
            $screen                   // Post type
        );
    }
}
add_action('add_meta_boxes', 'velo_add_home_section_type_box');
 
function velo_home_section_type_box_html($post)
{
    $value = get_post_meta($post->ID, '_velo_home_section_type', true);
    ?>
    <label for="velo_home_section_type">Section-Typ:</label><br><br>
    <select type="text" name='velo_home_section_type' value="<?php echo $value;?>" style='width: 100%;'>
        <option value='right-text'>Bild links</option>
        <option value='left-text'>Bild rechts</option>
        <option value='top-text'>Bild unten</option>
        <option value='overlay-text'>Nur Bild</option>
        <option value='only-text'>Nur Text</option>
        <option value='center'>Mittig</option>
    </select>
    <?php
}

function velo_home_section_save_postdata($post_id)
{
    if (array_key_exists('velo_home_section_type', $_POST)) {
        update_post_meta(
            $post_id,
            '_velo_home_section_type',
            $_POST['velo_home_section_type']
        );
    }
}
add_action('save_post', 'velo_home_section_save_postdata');

?>