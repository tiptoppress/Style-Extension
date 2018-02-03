<?php
/*
Plugin Name: Style Extension for the Term and Category Based Posts Widget
Plugin URI: http://tiptoppress.com/downloads/term-and-category-based-posts-widget/
Description: Adds a style pannel in the widgets admin that enables the control of some of the styling
Author: TipTopPress
Version: 0.1
Author URI: http://tiptoppress.com
*/

namespace termcategoryPostsPro\styleExtension;

// Don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

const TEXTDOMAIN = 'ttpStyleExtension';

add_action('cpwp_after_footer_panel',__NAMESPACE__.'\cpwp_after_footer_panel',10,2);

function cpwp_after_footer_panel($widget,$instance) {
	
	$instance = wp_parse_args( ( array ) $instance, array(
		'style_test'                => '',
	) );
?>
<h4 data-panel="style-extension"><?php _e('Style test',TEXTDOMAIN);?></h4>
<div>
	<p>
		<label for="<?php echo $widget->get_field_id("style_test"); ?>">
			<?php _e( 'style test',TEXTDOMAIN ); ?>:
			<input class="widefat" style="width:60%;" placeholder="<?php _e('styel test value',TEXTDOMAIN)?>" id="<?php echo $widget->get_field_id("style_test"); ?>" name="<?php echo $widget->get_field_name("style_test"); ?>" type="text" value="<?php echo esc_attr($instance["style_test"]); ?>" />
		</label>
	</p>
</div>
<?php	
}

add_filter('cpwp_default_settings',__NAMESPACE__.'\cpwp_default_settings');

function cpwp_default_settings($settings) {
	$setting['style_test'] = '';
}