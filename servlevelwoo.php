<?php
/**
 * Plugin Name:       ServLevelWoo
 * Plugin URI:        http://themes.tradesouthwest.com/wordpress/plugins/
 * Description:       Sorts product by using cart-collaterals Linked Products - opens from Settings Menu.
 * Version:           1.0.0
 * Author:            Larry Judd
 * Author URI:        http://tradesouthwest.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       servlevelwoo
 * Domain Path:       na using woocommerce i18n
 * @wordpress-plugin  wpdb = wp1v / _wp652
 * @link              http://tradesouthwest.com
 * @package           Servlevelwoo
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Important constants
 *
 * @since   1.0.1
 *
 * @version - reserved
 * @plugin_url
 * @text_domain - reserved
 *
 */
//define( 'MXMT_VERSION', '1.0.0' );
define( 'SERVLEVELWOO_URL', plugin_dir_url(__FILE__));
//define( 'MXMT_TEXT', 'mixmat' );

//activate/deactivate hooks
function servlevelwoo_plugin_activation() {

  // Check for WooCommerce
  if (!class_exists('WooCommerce')) {
	echo('<div class="error">
	<p>This plugin requires that WooCommerce is installed and activated.</p>
	</div></div>');
	return;
  }
  register_uninstall_hook( __FILE__, 'servlevelwoo_uninstall' );
}

function servlevelwoo_plugin_deactivation() {

    //servlevelwoo_deregister_shortcode();
        return false;
}

//https://codex.wordpress.org/Shortcode_API
function servlevelwoo_deregister_shortcode() {

//using uninstall
remove_shortcode( 'servlevelwoo_view_orders' );
}

/**
 * Initialise - load in translations
 * @since 1.0.0
 */
function servlevelwoo_loadtranslations () {

    $plugin_dir = basename(dirname(__FILE__)).'/languages';
    load_plugin_textdomain( 'servlevelwoo', false, $plugin_dir );

}
add_action('plugins_loaded', 'servlevelwoo_loadtranslations');

/**
 * Plugin Scripts
 *
 * Register and Enqueues plugin scripts
 *
 * @since 1.0.0
 */
function servlevelwoo_addtosite_scripts() {
$cstitle = get_option( 'servlevelwoo_options' )['servlevelwoo_cstitle_field'];
$csdescription = get_option( 'servlevelwoo_options' )['servlevelwoo_csdescription_field'];
$content = '';
   $content .= '@media (min-width:300px){.woocommerce-cart-wrap .cross-sells > h2{position:relative; left: -999em;font-size:1.214em;}.woocommerce-cart-wrap .cross-sells > h2:before{display:block!important;content:"' . $cstitle . '\A' . $csdescription . '";white-space:pre;position:relative;left: 999em;top:0;color: #000000;background-color:#8affc4;padding:3px;text-align:center}.woocommerce-cart-wrap .cross-sells{position:relative;top:-176px;}}'; 
    
    // Register Scripts
    
    wp_register_script( 'servlevelwoo-plugin', 
        plugins_url( 'lib/servlevelwoo-plugin.js', __FILE__ ), 
        array( 'jquery' ), true );
    /*
    wp_register_style( 'servlevelwoo-style', SERVLEVELWOO_URL . 'lib/servlevelwoo-style.css' );
   */
    //let WP handle ver and loading
    wp_enqueue_style(  'servlevelwoo-style' );
    wp_enqueue_script( 'servlevelwoo-plugin' );
    wp_register_style( 'servlevelwoo-entry-set', false );
    wp_enqueue_style(  'servlevelwoo-entry-set' );
   wp_add_inline_style( 'servlevelwoo-entry-set', $content );
}
add_action( 'wp_enqueue_scripts', 'servlevelwoo_addtosite_scripts' );
//load admin scripts as well
//add_action( 'admin_init', 'servlevelwoo_addtosite_scripts' );

//activate and deactivate registered
register_activation_hook( __FILE__, 'servlevelwoo_plugin_activation');
register_deactivation_hook( __FILE__, 'servlevelwoo_plugin_deactivation');

//include admin and public views
require ( plugin_dir_path( __FILE__ ) . 'inc/servlevelwoo-adminpage.php' ); 
require ( plugin_dir_path( __FILE__ ) . 'inc/servlevelwoo-subscription.php' ); 
require ( plugin_dir_path( __FILE__ ) . 'inc/servlevelwoo-addtocart.php' ); 
?>
