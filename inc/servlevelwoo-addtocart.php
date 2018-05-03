<?php 
defined( 'ABSPATH' ) or exit;
// @package servlevelwoo
add_action( 'init', 'servlevelwoo_register_shortcode' );
function servlevelwoo_register_shortcode()
{
add_shortcode('servlevelwoo_view_orders', 'servlevelwoo_shortcode_view_my_orders');
}
if( !function_exists('servlevelwoo_shortcode_view_my_orders')) : 
function servlevelwoo_shortcode_view_my_orders($atts= null) 
{
 extract( shortcode_atts( array(
        'order_count' => -1
    ), $atts ) );

    ob_start();
    wc_get_template( 'myaccount/my-orders.php', array(
        'current_user'  => get_user_by( 'id', get_current_user_id() ),
        'order_count'   => $order_count
    ) );
    return ob_get_clean(); 
    
} 
endif; 
