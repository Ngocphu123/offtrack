<?php
if ( ! session_id() ) {
session_start();
}
//constants
define( 'TRAV_VERSION', '1.9.4' );
define( 'TRAV_DB_VERSION', '1.6' );
define( 'TRAV_TEMPLATE_DIRECTORY_URI', get_template_directory_uri() );
define( 'TRAV_INC_DIR', get_template_directory() . '/inc' );
define( 'TRAV_IMAGE_URL', TRAV_TEMPLATE_DIRECTORY_URI . '/images' );
define( 'TRAV_TAX_META_DIR_URL', TRAV_TEMPLATE_DIRECTORY_URI . '/inc/lib/tax-meta-class/' );
define( 'RWMB_URL', TRAV_TEMPLATE_DIRECTORY_URI . '/inc/lib/meta-box/' );

global $wpdb;
define( 'TRAV_ACCOMMODATION_VACANCIES_TABLE', $wpdb->prefix . 'trav_accommodation_vacancies' );
define( 'TRAV_ACCOMMODATION_BOOKINGS_TABLE', $wpdb->prefix . 'trav_accommodation_bookings' );
define( 'TRAV_CURRENCIES_TABLE', $wpdb->prefix . 'trav_currencies' );
define( 'TRAV_REVIEWS_TABLE', $wpdb->prefix . 'trav_reviews' );
define( 'TRAV_MODE', 'product' );
define( 'TRAV_TOUR_SCHEDULES_TABLE', $wpdb->prefix . 'trav_tour_schedule' );
define( 'TRAV_TOUR_BOOKINGS_TABLE', $wpdb->prefix . 'trav_tour_bookings' );
// define( 'TRAV_MODE', 'dev' );

// require file to woocommerce integration
require_once( TRAV_INC_DIR . '/functions/woocommerce/woocommerce.php' );

// get option
// $trav_options = get_option( 'travelo' );
if ( ! class_exists( 'ReduxFramework' ) ) {
    require_once( dirname( __FILE__ ) . '/inc/lib/redux-framework/ReduxCore/framework.php' );
}
if ( ! isset( $redux_demo ) ) {
    require_once( dirname( __FILE__ ) . '/inc/lib/redux-framework/config.php' );
}

//require files
require_once( TRAV_INC_DIR . '/functions/main.php' );
require_once( TRAV_INC_DIR . '/functions/js_composer/init.php' );
require_once( TRAV_INC_DIR . '/admin/main.php');
require_once( TRAV_INC_DIR . '/frontend/accommodation/main.php');
require_once( TRAV_INC_DIR . '/frontend/tour/main.php');

// Content Width
if (!isset( $content_width )) $content_width = 1000;

// Translation
load_theme_textdomain('trav', get_stylesheet_directory() . '/languages');

//theme supports
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'woocommerce' );
add_image_size( 'list-thumb', 230, 160, true );
add_image_size( 'gallery-thumb', 270, 160, true );
add_image_size( 'biggallery-thumb', 500, 300, true );
add_image_size( 'widget-thumb', 64, 64, true );

function load_scripts() {
    global $post;

    if( is_page() || is_single() )
    {
        switch($post->post_type)
        {
            case 'tour':
                wp_enqueue_style( 'timeline', get_template_directory_uri() . '/css/timeline.css', false, '1.0', 'all' );
                wp_enqueue_style( 'rubytabs', get_template_directory_uri() . '/css/rubytabs.css', false, '1.0', 'all' );
                wp_enqueue_script('vendors', get_template_directory_uri() . '/js/vendors.min.js', array('jquery'), false, true);
                wp_enqueue_script('rubytabs', get_template_directory_uri() . '/js/rubytabs.js', array('jquery'), false, true);
                wp_enqueue_script('scrollable', get_template_directory_uri() . '/js/scrollable.min.js', array('jquery'), false, true);
                //wp_enqueue_script('jssorslider', get_template_directory_uri() . '/js/jssor.slider.min.js', array('jquery'), '1.6', true);
                break;
        }
    }
}

add_action('wp_enqueue_scripts', 'load_scripts');

// My custom codes will be here
add_action( 'admin_init', 'my_custom_codes_init_func' );

function my_custom_codes_init_func() {
    //$id, $title, $callback, $page, $context, $priority, $callback_args
    add_meta_box("itinerary", 'Lịch trình', 'my_custom_metabox_func', 'tour', 'normal', 'low');
}

function my_custom_metabox_func() {
    global $post;

    $date_itinerary     =   get_post_meta($post->ID, 'date_itinerary', true);
    $title_itinerary    =   get_post_meta($post->ID, 'title_itinerary', true);
    $content_itinerary  =   get_post_meta($post->ID, 'content_itinerary', true);
    ?>
    <div class="input_fields_wrap">
        <a class="add_field_button button-secondary">Add Field</a>
        <?php
        $settings =   array(
            'wpautop' => true, //Whether to use wpautop for adding in paragraphs. Note that the paragraphs are added automatically when wpautop is false.
            'media_buttons' => true, //Whether to display media insert/upload buttons
            'textarea_name' => "content_itinerary[]", // The name assigned to the generated textarea and passed parameter when the form is submitted.
            'textarea_rows' => get_option('default_post_edit_rows', 10), // The number of rows to display for the textarea
            'tabindex' => '', //The tabindex value used for the form field
            'editor_css' => '', // Additional CSS styling applied for both visual and HTML editors buttons, needs to include <style> tags, can use "scoped"
            'editor_class' => '', // Any extra CSS Classes to append to the Editor textarea
            'teeny' => false, // Whether to output the minimal editor configuration used in PressThis
            'dfw' => false, // Whether to replace the default fullscreen editor with DFW (needs specific DOM elements and CSS)
            'tinymce' => true, // Load TinyMCE, can be used to pass settings directly to TinyMCE using an array
            'quicktags' => true, // Load Quicktags, can be used to pass settings directly to Quicktags using an array. Set to false to remove your editor's Visual and Text tabs.
            'drag_drop_upload' => true //Enable Drag & Drop Upload Support (since WordPress 3.9)
        );
        if(isset($date_itinerary) && is_array($date_itinerary)) {
            $i = 1;
            $output = '';
            foreach($date_itinerary as $key => $text){
                //echo $text;
                echo '<div style="margin-top: 20px;margin-bottom: 20px;padding-bottom: 20px;border-bottom: 1px dotted #e5e5e5;">' .
                            '<div class="rwmb-field rwmb-textarea-wrapper">' .
                            '<div class="rwmb-label"><label for="">Ngày </label></div>' .
                            '<div class="rwmb-input"><input type="text" name="date_itinerary[]" value="' . $text . '"/></div>' .
                            '</div>' .
                            '<div class="rwmb-field rwmb-textarea-wrapper">' .
                            '<div class="rwmb-label"><label for="">Tiêu đề </label></div>' .
                            '<div class="rwmb-input"><input type="text" name="title_itinerary[]" value="' . $title_itinerary[$key] . '"/></div>' .
                            '</div>' .
                            '<div class="rwmb-field rwmb-textarea-wrapper editor">' .
                            '<label for="">Nội dung </label></div>';
                echo '<div id="wp-content-editor-container" class="wp-editor-container">' . wp_editor($content_itinerary[$key], $text, $settings) . '</div>';
                echo
                            '<div class="remove_field_itinerary_bt"><a href="#" class="remove_field_itinerary_a" data-editor_id="'. $key .'">Remove</a></div>' .
                            '</div>';

                $i++;
            }
        } else {
            //echo '<div><input type="text" name="mytext[]"></div>';
        }
        ?>
    </div>

    <?php
}
add_action( 'admin_init', 'my_custom_codes_init_func' );

add_action('save_post', 'save_my_post_meta');

function save_my_post_meta($post_id) {
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;

    // now we can actually save the data
    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
    // If any value present in input field, then update the post meta
        update_post_meta( $post_id, 'date_itinerary', isset($_POST['date_itinerary'])?$_POST['date_itinerary']:"" );
        update_post_meta( $post_id, 'title_itinerary', isset($_POST['title_itinerary'])?$_POST['title_itinerary']:"" );
        update_post_meta( $post_id, 'content_itinerary', isset($_POST['content_itinerary'])?$_POST['content_itinerary']:"" );
}

add_action('admin_footer', 'my_admin_footer_script');

function my_admin_footer_script() {
    global $post;

    $tilte_itinerary =   get_post_meta($post->ID, 'tilte_itinerary', true);
    $x = 1;
    if(is_array($tilte_itinerary)) {
        $x = 0;
        foreach($tilte_itinerary as $text){
            $x++;
        }
    }
    if(  'tour' == $post->post_type ) {
        echo '
<script type="text/javascript">
jQuery(document).ready(function($) {

    // Dynamic input fields ( Add / Remove input fields )
    var max_fields      = 50; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = '.$x.'; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x <= max_fields){ //max input box allowed
            x++; //text box increment
            alert(x);
            var html = \'<div style="    margin-top: 20px;margin-bottom: 20px;padding-bottom: 20px;border-bottom: 1px dotted #e5e5e5;">\'+
             \'<div class="rwmb-field rwmb-textarea-wrapper">\'+
             \'<div class="rwmb-label"><label for="">Ngày </label></div>\'+
             \'<div class="rwmb-input"><input type="text" name="date_itinerary[]"/></div>\'+
             \'</div>\'+
             \'<div class="rwmb-field rwmb-textarea-wrapper">\'+
             \'<div class="rwmb-label"><label for="">Tiêu đề </label></div>\'+
             \'<div class="rwmb-input"><input type="text" name="title_itinerary[]"/></div>\'+
             \'</div>\'+
             \'<div class="rwmb-field rwmb-textarea-wrapper editor">\'+
             \'<label for="">Nội dung </label></div>\'+
             \'<div id="wp-content-editor-container" class="wp-editor-container"><textarea id="editor-\'+ x +\'" class="cn-wp-editor" name="content_itinerary[]"/></textarea>\'+
             \'</div>\'+
             \'<div class="remove_field_itinerary_bt"><a href="#" class="remove_field_itinerary_a" data-editor_id="\'+x+\'">Remove</a></div>\'+
              \'</div>\';
            $(wrapper).append(html);
            tinymce.execCommand(\'mceAddEditor\', false, "editor-" +x);
            
        }
    });

    $(wrapper).on("click",".remove_field_itinerary_bt", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent(\'div\').remove();
        var editor_id = $(this).attr(\'data-editor_id\');
        tinymce.execCommand( \'mceRemoveEditor\', false, "editor-" +editor_id );
    })
});
</script>
                ';
    }
}
/*add_action('admin_enqueue_scripts', 'admin_enqueue_scripts_func');

function admin_enqueue_scripts_func() {
    //$name, $src, $dependencies, $version, $in_footer
    wp_enqueue_script( 'my-script', get_template_directory_uri() . '/js/dynamic-fields.js', array( 'jquery' ), '20160816', true );
}*/
add_action( 'admin_print_styles-post-new.php', 'tour_admin_style', 11 );
add_action( 'admin_print_styles-post.php', 'tour_admin_style', 11 );

function tour_admin_style() {
    global $post_type;
    if( 'tour' == $post_type )
        wp_enqueue_style( 'tour-admin-style', get_stylesheet_directory_uri() . '/tour-admin.css' );
}

add_action( 'wp_enqueue_scripts', 'load_old_jquery_fix', 100 );

function load_old_jquery_fix() {
    if ( ! is_admin() ) {
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', ( "//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" ), false, '1.11.3' );
        wp_enqueue_script( 'jquery' );
    }
}