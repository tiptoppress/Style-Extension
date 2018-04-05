<?php
/*
Plugin Name: Style Extension for the Term and Category Based Posts Widget
Plugin URI: http://tiptoppress.com/downloads/term-and-category-based-posts-widget/
Description: Adds a style pannel in the widgets admin that enables the control of some of the styling
Author: TipTopPress
Version: 0.1
Author URI: http://tiptoppress.com
*/

namespace termCategoryPostsPro\styleExtension;

// Don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

const VERSION        = '0.1';
const TEXTDOMAIN     = 'style-extension';
const MINBASEVERSION = "4.7.1";

// private function section

 /**
 * Check the Term and Category based Posts Widget version
 *
 *  @return Base widget supporteds this Extension version
 *
 */
function version_check( $min_base_version = MINBASEVERSION ) {
	$min_base_version = explode('.', $min_base_version);

	if ( !defined( '\termcategoryPostsPro\VERSION' ) ) return false;
	$installed_base_version = explode('.', \termcategoryPostsPro\VERSION);

	$ret = ($min_base_version[0] < $installed_base_version[0]) ||
			($min_base_version[0] == $installed_base_version[0] && $min_base_version[1] <= $installed_base_version[1]);

	return $ret;
}

// Plugin filter and action section

/**
 * Enqueue widget related scripts for the widget admin page and customizer.
 *
 * @param string $hook the name of the admin hook for which the function was triggered.
 */
function admin_scripts( $hook ) {

	if ( 'widgets.php' === $hook ) { // enqueue only for widget admin and customizer.

		// control open and close the widget section.
		wp_register_script( 'style-extension-admin-js', plugins_url( 'js/admin/style-extension.js', __FILE__ ), array( 'jquery' ), VERSION, true );
		wp_enqueue_script( 'style-extension-admin-js' );
	}
}

add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\admin_scripts' );

/**
 *  Applied to the list of links to display on the plugins page (beside the activate/deactivate links).
 *
 *  @return array of the widget links
 *
 *  @since 0.1
 */
function add_action_links ( $links ) {
    $pro_link = array(
        '<a target="_blank" href="http://tiptoppress.com/term-and-category-based-posts-widget/?utm_source=widget_seoext&utm_campaign=get_pro_seoext&utm_medium=action_link">'.__('Get the pro widget needed for this extension','category-posts').'</a>',
    );

	$links = array_merge($pro_link, $links);

    return $links;
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), __NAMESPACE__.'\add_action_links' );

 /**
 * Add add-on settings to widget settings
 *
 */
function cpwp_default_settings($settings) {
	return wp_parse_args( ( array ) $settings, array(
		'style_test'         => '',
	) );
}

add_filter('cpwp_default_settings',__NAMESPACE__.'\cpwp_default_settings');

 /**
 * Write admin notice if a higher version is needed
 *
 */
function version_notice() {
	if ( ! version_check() ) {
		?>
		<div class="update-nag notice">
			<p><?php printf( __( 'The SEO-Link Extension needs the Term and Category based Posts Wiedget version %s or higher. It is possible that some features are not available. Please <a href="%s">update</a>.', 'category-posts' ), MINBASEVERSION, admin_url('plugins.php') ); ?></p>
		</div>
		<?php
	}
}

add_action( 'admin_notices', __NAMESPACE__.'\version_notice' );

function cpwp_after_footer_panel($widget,$instance) {

	if ( ! version_check( MINBASEVERSION ) ) {
		return;
	}

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

add_action('cpwp_after_footer_panel',__NAMESPACE__.'\cpwp_after_footer_panel',10,2);
