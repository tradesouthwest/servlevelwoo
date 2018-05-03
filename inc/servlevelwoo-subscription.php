<?php 
/** @package servlevelwoo plugin
 *  u/c = uncomment to run
 * $price = get_post_meta($values['product_id'] , '_price', true);
 */
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Find current subcription category 
 * 'shop_subscription'  subscription_id subscription_status
 * Return true if NOT matching cart subscription cat (means _update add_to_cart)
 * @param $prod_cat= return cart subscription current cat
 * @param $req_subscription= test to get highest level of subscription fee
 * woocommerce_cart_page_id
 */
function servlevelwoo_find_subscription_cat($product)
{ 
global $product;
    //$crosssells = get_post_meta( $product, '_crosssell_ids', true );
    if ( is_page() || is_page('cart') ) { 
    //$related = $product->get_cross_sells();

   /* if($related) { 
        return true;
        } 
        else { */
        return true;   
    }   
   //}  
}    

/**
 * Add next level subscription to cart 
 * 
 * ref. https://github.com/wp-premium/woocommerce-subscriptions/blob/master/includes/class-wc-subscriptions-cart.php
 * @param $req_subscription Boolean
 * @param $recurring_cart_key  
 * An internal pointer to the current recurring cart calculation (if any)
 */
function servlevelwoo_loop_add_to_cart($cart)
{ 
global $woocommerce, $product; 

$req_subscription = servlevelwoo_find_subscription_cat($product);
//if(WC_Subscriptions_Cart::cart_contains_subscription()):
if($req_subscription === true) :
    if ( !empty( $cart->recurring_cart_key ) ){
        $cart_fee = $cart->add_fee( 'Monthly Fee Increase', '10' );
    }
//shows above Tax and below Subtotal        
        return $cart_fee; 
    
    endif; 
}
add_filter('woocommerce_cart_calculate_fees', 'servlevelwoo_loop_add_to_cart', 10, 1);

//get highest level required from cart items 
//see readme.txt for ref.
function servlevelwoo_get_product_cat($prod_cat) 
{
if($prod_cat == '') return;
 $prod_cat = get_terms( array( 'taxonomy'   => 'product_cat', 
                               'hide_empty' => true, ) );
    
    switch ($prod_cat) {
        case 'video':
            $prod_cats = 'video';
            break;
        case 'access':
            $prod_cats = 'access';
            break;
        case 'comfort':
            $prod_cats = 'comfort';
            break;
        case 'security':
            $prod_cats = 'security';
            break;
        case ('video' && 'access'):
            $prod_cats = 'video';
            break;
        case ('access' && 'security'):
            $prod_cats = 'access';
            break;
        case ('video' && 'comfort'):
            $prod_cats = 'video';
            break;
        case ('comfort' && 'security'):
            $prod_cats = 'comfort';
            break;
        case ('security' && 'video'): 
            $prod_cats = 'video';
            break;
        default : '';
    }

        return $prod_cats;
}

