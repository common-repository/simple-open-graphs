<?php 
$args = array(
   'public'   => true,
);
  
$output = 'objects'; // 'names' or 'objects' (default: 'names')
$post_typs = get_post_types($args, $output); 

$saved_sog_settings = get_option( 'sog_settings' );
?>
<h3><?php _e("Simple Open Graphs - Facebook Rich Snippets", "simple-open-graphs"); ?></h3>

<form id="sog-form" style="padding: 0 30px;">
<input type="hidden" name="action" value="save_open_graphs_settings">
	<?php foreach ($post_typs as $post_type) { 
		$checked = !empty($saved_sog_settings) && in_array($post_type->name, $saved_sog_settings)  ? "checked" : "";
		?>
		<input <?php echo $checked; ?> type="checkbox" id="<?php echo $post_type->name; ?>" value="<?php echo $post_type->name; ?>" name="post_type[]"> <label for="<?php echo $post_type->name; ?>"><?php echo $post_type->label; ?></label><br><br>
	<?php 	
	} ?>
	<input type="submit" class="button button-primary submit-button" value="Save Settings">
	<img id="loader-image" src="<?php echo plugin_dir_url( __FILE__ ) ?>loader.gif" style="display:none;">
	<span class="seetings-msg" style="vertical-align: bottom"> </span>
</form>