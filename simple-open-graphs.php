<?php 
/*
Plugin Name: Simple Open Graphs
Description: Easily add open graph meta tags in your site
Plugin URI: https://webcodingplace.com/simple-open-graphs
Author: WebCodingPlace
Author URI: https://webcodingplace.com
Version: 1.0
License: GPL2
Text Domain: simple-open-graphs
*/

/**
* Main Class
*/
class Simple_Open_Graphs
{
	
	function __construct(){
		add_action( 'admin_menu', array( $this, 'menu_pages' ) );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_scripts' ) );
		add_action( 'wp_ajax_save_open_graphs_settings', array($this, 'save_settings') );
		add_action( 'add_meta_boxes', array($this, 'metaboxes' ) );
		add_action( 'save_post', array($this, 'save_graphs_settings') );
		add_action( 'wp_head', array($this, 'adding_facebook_schema') );
	}
	function adding_facebook_schema(){
		global $post;
		if (!empty($post) && isset($post->ID)) {
		$post_id = $post->ID;
		$post_type = $post->post_type;
		$saved_sog_settings = get_option( 'sog_settings' );
		$sog_page_disable = get_post_meta( $post_id, 'sog_page_disable', true );
		
			if (is_array($saved_sog_settings) && in_array($post_type, $saved_sog_settings) && $sog_page_disable != "on" ) {
				
				$title = get_post_meta( $post_id, 'sog_title', true );
				if ( empty($title) ) {
					$title = get_the_title( $post_id );
				}
				
				$content = get_post_meta( $post_id, 'sog_description', true );
				if (empty($content) || $content == '') {
					$content_post = get_post($post_id);
					$content = $content_post->post_content;	
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					$content = wp_trim_words( $content, 156, '...' );
				}
				$site_name = get_post_meta( $post_id, 'sog_site_name', true );
				if (empty($site_name)) {
					$site_name = get_bloginfo('name');
				}				
				$post_url = get_post_meta( $post_id, 'sog_post_url', true );
				if (empty($post_url) || $post_url == '') {
					$post_url = get_permalink( $post_id );
				}

				$mime_type = 'image/jpeg';
				$image_url = get_post_meta( $post_id, 'sog_image_url', true );
				if (empty($image_url) || $image_url == '') {
					$image_url = get_the_post_thumbnail_url($post_id);
					$thumbail_id = get_post_thumbnail_id( $post_id );
					$attachment_meta = wp_get_attachment_metadata( $thumbail_id );
					if (isset($attachment_meta['sizes']['thumbnail']['mime-type'])) {
						$mime_type = $attachment_meta['sizes']['thumbnail']['mime-type'];
					}
				} else {
					$file = get_headers($image_url, 1);
					$mime_type = $file['Content-Type'];
				}
				$type = "article";
				if ($post_type == "page") {
					$type = "website";
				}
				?>
					<meta property="og:type"                 content="<?php echo esc_attr( $type ); ?>" />
					<meta property="og:title"                 content="<?php echo esc_attr( $title ); ?>" />
					<meta property="og:description"     content="<?php echo esc_attr( $content ); ?>"/>
					<meta property="og:url"                   content="<?php echo esc_attr( $post_url ); ?>" />
					<meta property="og:image:type"     content="<?php echo esc_attr( $mime_type ); ?>" />
					<meta property="og:image"             content="<?php echo esc_attr( $image_url ); ?>" />
					<meta property="og:image:url"         content="<?php echo esc_attr( $image_url ); ?>" />
					<meta property="og:site_name"         content="<?php echo esc_attr( $site_name ); ?>" />
		<?php
			}
		}
	}

	function menu_pages(){
		add_submenu_page( '/tools.php', 'Simple Open Graphs', __( 'Simple Open Graphs', 'simple-open-graphs' ), 'manage_options', 'simple-open-graphs', array($this, 'render_graph') );
	}
	function render_graph(){
		include_once 'graphs-settings.php';
	}

	function admin_scripts($check){
		if ( $check == 'tools_page_simple-open-graphs') {
			wp_enqueue_script( 'rem-select2-js', plugin_dir_url( __FILE__ ) . 'scripts.js' , array('jquery'));
		}
	}

	function save_settings(){
		$update = false;
		if (isset($_REQUEST['post_type'])) {
			$data = array_map( 'esc_attr', $_REQUEST['post_type'] );
			$update = update_option( 'sog_settings', $data );
		}else {
			$update = update_option( 'sog_settings', '' );
		}

		wp_send_json( $update );
	}

	function metaboxes(){
		$saved_sog_post_types = get_option( 'sog_settings' );
		if (!empty($saved_sog_post_types)) {
			
			add_meta_box( 'sog_metabox', __( 'Simple Open Graphs - Facebook Rich Snippets', '' ), array($this, 'render_meta_settings' ), $saved_sog_post_types );
		}

	}

	function render_meta_settings(){
		include_once 'metabox-fields.php';
	}

	function save_graphs_settings($post_id){
		        // verify if this is an auto save routine. 
        // If it is our form has not been submitted, so we dont want to do anything
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
            return;
        
        if (isset($_POST['sog_title'])) {
            update_post_meta( $post_id, 'sog_title', sanitize_text_field( $_POST['sog_title'] ) );
        }

        if (isset($_POST['sog_description'])) {
            update_post_meta( $post_id, 'sog_description', sanitize_text_field( $_POST['sog_description'] ) );
        }

        if (isset($_POST['sog_post_url'])) {
            update_post_meta( $post_id, 'sog_post_url', sanitize_text_field( $_POST['sog_post_url'] ) );
        }

        if (isset($_POST['sog_image_url'])) {
            update_post_meta( $post_id, 'sog_image_url', sanitize_text_field( $_POST['sog_image_url'] ) );
        }

        if (isset($_POST['sog_site_name'])) {
            update_post_meta( $post_id, 'sog_site_name', sanitize_text_field( $_POST['sog_site_name'] ) );
        }

        if (isset($_POST['sog_page_disable'])) {
            update_post_meta( $post_id, 'sog_page_disable', sanitize_text_field( $_POST['sog_page_disable'] ) );
        } else {
            update_post_meta( $post_id, 'sog_page_disable', "" );
        }
	}
}

// init class object
$obj = new Simple_Open_Graphs;
?>