<?php 
	global $post;
	$post_id = $post->ID;
	$post_type = $post->post_type;
	// for placholders
	$content = 'By default, this plugin will display the first 156 characters of your post as the og:description';	
	// for values
	$sog_title = get_post_meta( $post_id, 'sog_title', true );
	$sog_description = get_post_meta( $post_id, 'sog_description', true );
	$sog_post_url = get_post_meta( $post_id, 'sog_post_url', true );
	$sog_image_url = get_post_meta( $post_id, 'sog_image_url', true );
	$sog_site_name = get_post_meta( $post_id, 'sog_site_name', true );
	$sog_page_disable = get_post_meta( $post_id, 'sog_page_disable', true );
	$checked = !empty($sog_page_disable) && $sog_page_disable == "on" ? "checked" : "";

	// for post type lable
	$post_type_obj = get_post_type_object($post_type);
	$post_type_label = $post_type_obj->labels->singular_name;
?>
<div class="wrapper">
	<div class="col-2"><label for="" class="control-label"><?php _e( "$post_type_label Title : ", "simple-open-graphs" ); ?></label></div>
	<div class="col-8"><input type="text" placeholder="<?php echo get_the_title( $post_id ); ?>" name="sog_title" class="form-control" value="<?php echo esc_attr( $sog_title ); ?>"></div>
	<div class="clear"></div>

	<div class="col-2"><label for="" class="control-label"><?php _e( "$post_type_label Description  : ", "simple-open-graphs" ); ?></label></div>
	<div class="col-8"><input type="text" placeholder="<?php echo $content; ?>" name="sog_description" class="form-control" value="<?php echo esc_attr( $sog_description ); ?>"></div>
	<div class="clear"></div>

	<div class="col-2"><label for="" class="control-label"><?php _e( "$post_type_label URL : ", "simple-open-graphs" ); ?></label></div>
	<div class="col-8"><input type="url" placeholder="<?php echo get_permalink( $post_id ); ?>" name="sog_post_url" class="form-control" value="<?php echo esc_attr( $sog_post_url ); ?>"></div>
	<div class="clear"></div>

	<div class="col-2"><label for="" class="control-label"><?php _e( "$post_type_label Image URL : ", "simple-open-graphs" ); ?></label></div>
	<div class="col-8"><input type="url" placeholder="<?php echo get_the_post_thumbnail_url($post_id); ?>" name="sog_image_url" class="form-control" value="<?php echo esc_attr( $sog_image_url ); ?>"></div>
	<div class="clear"></div>

	<div class="col-2"><label for="" class="control-label"><?php _e( "$post_type_label Site Name : ", "simple-open-graphs" ); ?></label></div>
	<div class="col-8"><input type="text" placeholder="<?php echo bloginfo('name'); ?>" name="sog_site_name" class="form-control" value="<?php echo esc_attr( $sog_site_name ); ?>"></div>
	<div class="clear"></div>

	<div class="col-2"><label for="" class="control-label"><?php _e( "Disable on this $post_type_label : ", "simple-open-graphs" ); ?></label></div>
	<div class="col-8"><input type="checkbox" name="sog_page_disable" class="form-control" <?php echo $checked; ?>></div>
	<div class="clear"></div>
</div>
<style>
	.col-2 {
		width: 20%;
		float: left;
		text-align: center;
	}
	.col-8 {
		width: 80%;
		float: left;
	}
	.clear {
		clear: both;
		margin-bottom: 10px;
	}
	.form-control {
	  display: block;
	  width: 100%;
	  height: 34px;
	  padding: 6px 12px;
	  font-size: 14px;
	  line-height: 1.42857143;
	  color: #555;
	  background-color: #fff;
	  background-image: none;
	  border: 1px solid #ccc;
	  border-radius: 4px;
	  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
	  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
	  -webkit-transition: border-color ease-in-out 0.15s, -webkit-box-shadow ease-in-out 0.15s;
	  -o-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
	  transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
	}
	.ich-settings-main-wrap .form-control:focus {
	  border-color: #66afe9;
	  outline: 0;
	  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
	  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
	}
	.control-label {
	  display: inline-block;
	  max-width: 100%;
	  margin-bottom: 5px;
	  font-weight: bold;
	  margin-top: 6px;
	}
</style>