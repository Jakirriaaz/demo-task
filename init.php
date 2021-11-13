<?php 

/**
 * Plugin Name:       Demo Task
 * Plugin URI:        https://jakirriaaz.com/plugins/basic-form/
 * Description:       Handle the basics form with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Jakir H.
 * Author URI:        https://jakirriaaz.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       dt-demo-task
 * Domain Path:       /languages
 */

 
defined('ABSPATH') or die('directory path is desabled');

//start from here

class Dt_demo_task{
   
    public function __construct(){

        if(file_exists(dirname(__FILE__) .'/process.php')){
            //require_once(dirname(__FILE__) .'/process.php');
         }
        
        add_action('init', array($this, 'dt_demo_task'));
        add_action('add_meta_boxes', array($this, 'additional_custome_field'));
        add_action('save_post', array($this, 'additional_custome_field_save'));
        add_action('admin_enqueue_scripts', array($this, 'dt_enqueue_files'));
    }

    public function dt_enqueue_files(){
        wp_register_style('custom-style', PLUGINS_URL('css/style.css', __FILE__));
        wp_enqueue_style('custom-style');
        wp_enqueue_script('custom-js', PLUGINS_URL('js/custom.js', __FILE__), array('jquery'));
    }

    public function dt_demo_task() {
        $labels = array(
            'name'                  => _x( 'Task', 'Post type general name', 'dt-demo-task' ),
            'singular_name'         => _x( 'Task', 'Post type singular name', 'dt-demo-task' ),
            'menu_name'             => _x( 'Tasks', 'Admin Menu text', 'dt-demo-task' ),
            'name_admin_bar'        => _x( 'Task', 'Add New on Toolbar', 'dt-demo-task' ),
            'add_new'               => __( 'Add New', 'dt-demo-task' ),
            'add_new_item'          => __( 'Add New Task', 'dt-demo-task' ),
            'new_item'              => __( 'New Task', 'dt-demo-task' ),
            'edit_item'             => __( 'Edit Task', 'dt-demo-task' ),
            'view_item'             => __( 'View Task', 'dt-demo-task' ),
            'all_items'             => __( 'All Tasks', 'dt-demo-task' ),
            'search_items'          => __( 'Search Tasks', 'dt-demo-task' ),
            'parent_item_colon'     => __( 'Parent Tasks:', 'dt-demo-task' ),
            'not_found'             => __( 'No Tasks found.', 'dt-demo-task' ),
            'not_found_in_trash'    => __( 'No Tasks found in Trash.', 'dt-demo-task' ),
            'featured_image'        => _x( 'Task Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'dt-demo-task' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'dt-demo-task' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'dt-demo-task' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'dt-demo-task' ),
            'archives'              => _x( 'Task archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'dt-demo-task' ),
            'insert_into_item'      => _x( 'Insert into Task', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'dt-demo-task' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this Task', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'dt-demo-task' ),
            'filter_items_list'     => _x( 'Filter Tasks list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'dt-demo-task' ),
            'items_list_navigation' => _x( 'Tasks list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'dt-demo-task' ),
            'items_list'            => _x( 'Tasks list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'dt-demo-task' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'task' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-rss',
            'supports'           => array(''),
        );

        register_post_type( 'demotask', $args );

    }

    public function additional_custome_field(){

        //Meta-box for additional field
        add_meta_box('demotaskid', 'List of Employees', array($this, 'singer_information'), 'demotask', 'normal');
    }

    public function singer_information(){

        $value = get_post_meta(get_the_id(), 'demotaskid', true);
        ?>
        
        <div class="form-group">
            <form class="add_name" id="add_name" action="_blank" method="POST">
                <table class="form-table editcomment" id="dynamic_field">
                    <tbody>
                        <tr>
                            <td><input class="widefat" type="text" name="name" value="<?php echo esc_attr($value); ?>" id="name" placeholder="Name of the Person"></td>
                        </tr>
                        <tr>
                            <td><button class="btn custom-btn" type="button" name="add_btn" id="add_btn">Add More</button></td>
                        </tr>
                        <tr>
                            <td><input class="btn custom-submit" type="button" name="submit" value="Save Settings" id="submit"></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>


        <?php
    }

    public function additional_custome_field_save($post_id){
        $name = $_POST['name'];
        update_post_meta($post_id, 'demotaskid', $name);
    }
   
}

$demotask = new Dt_demo_task();