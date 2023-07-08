<?php

add_action('wp_enqueue_scripts', static function () {
    $deps = [];

    if (class_exists(\Elementor\Plugin::class)) {
        $deps[] = 'elementor-frontend';
    }

    wp_enqueue_style('vehica', get_template_directory_uri() . '/style.css', $deps, VEHICA_VERSION);
    wp_enqueue_style('vehica-child', get_stylesheet_directory_uri() . '/style.css', ['vehica']);
});

add_action('after_setup_theme', static function () {
    load_child_theme_textdomain('vehica', get_stylesheet_directory() . '/languages');
});


// Add meta box for custom image field
function my_custom_meta_box() {
    add_meta_box(
        'custom_image_field', // Meta box ID
        'Custom Image Field For Flip Image', // Meta box title
        'render_custom_image_field', // Callback function to render the meta box content
        'vehica_car', // Post type
        'normal', // Position
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'my_custom_meta_box');

// Render custom image field
function render_custom_image_field($post) {
    wp_nonce_field('custom_image_field_nonce', 'custom_image_field_nonce');
    
    $image_url = get_post_meta($post->ID, 'custom_image_field', true);
    $image_id = attachment_url_to_postid($image_url);
    
    ?>
    <div>
        <label for="custom_image">Custom Image:</label>
        <input type="text" id="custom_image" name="custom_image" value="<?php echo $image_url; ?>" readonly>
        <input type="button" id="upload_image_button" class="button" value="Upload Image">
        <input type="button" id="remove_image_button" class="button" value="Remove Image">
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var mediaUploader;
        
        $('#upload_image_button').click(function(e) {
            e.preventDefault();
            
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Select'
                },
                multiple: false
            });
            
            mediaUploader.on('select', function() {
                attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#custom_image').val(attachment.url);
            });
            
            mediaUploader.open();
        });
        
        $('#remove_image_button').click(function(e) {
            e.preventDefault();
            $('#custom_image').val('');
        });
    });
    </script>
    <?php
}

// Save custom image field data
function save_custom_image_field($post_id) {
    if (!isset($_POST['custom_image_field_nonce']) || !wp_verify_nonce($_POST['custom_image_field_nonce'], 'custom_image_field_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['custom_image'])) {
        $image_url = sanitize_text_field($_POST['custom_image']);
        update_post_meta($post_id, 'custom_image_field', $image_url);
    }
}
add_action('save_post', 'save_custom_image_field');

// Get custom image URL
// $custom_image_url = get_post_meta(get_the_ID(), 'custom_image_field', true);

// // Display custom image
// if ($custom_image_url) {
//     echo '<img src="' . esc_attr($custom_image_url) . '" alt="Custom Image">';
// }

