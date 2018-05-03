<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @package    servlevelwoo
 * @subpackage servlevelwoo/inc
 * @author     Larry Judd <tradesouthwest@gmail.com>
 */
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
function servlevelwoo_add_options_page() 
{
   add_submenu_page(
       'options-general.php',
        esc_html__( 'ServiceLevel', 'servlevelwoo' ),
        esc_html__( 'ServiceLevel', 'servlevelwoo' ),
        'manage_options',
        'servlevelwoo',
        'servlevelwoo_options_page',
        'dashicons-admin-tools' 
    );
}   add_action( 'admin_menu', 'servlevelwoo_add_options_page' ); 
 
/** a.) Register new settings
 *  $option_group (page), $option_name, $sanitize_callback
 *  --------
 ** b.) Add sections
 *  $id, $title, $callback, $page
 *  --------
 ** c.) Add fields 
 *  $id, $title, $callback, $page, $section, $args = array() 
 *  --------
 ** d.) Options Form Rendering. action="options.php"
 *
 */
add_action( 'admin_init', 'servlevelwoo_register_admin_options' ); 
// a.) register all settings groups
function servlevelwoo_register_admin_options() 
{
    //options pg
    register_setting( 'servlevelwoo_options', 'servlevelwoo_options' );
     

/**
 * b1.) options section
 */        
    add_settings_section(
        'servlevelwoo_options_section',
        esc_html__( 'Levels of Service', 'woocommerce' ),
        'servlevelwoo_options_section_cb',
        'servlevelwoo_options'
    ); 
        // c.) settings 
    add_settings_field(
        'servlevelwoo_cstitle_field',
        esc_attr__('Title for Cart Cross Sell', 'woocommerce'),
        'servlevelwoo_cstitle_field_cb',
        'servlevelwoo_options',
        'servlevelwoo_options_section',
        array( 
            'type'         => 'text',
            'option_group' => 'servlevelwoo_options', 
            'name'         => 'servlevelwoo_cstitle_field',
            'value'        => 
            esc_attr( get_option( 'servlevelwoo_options' )['servlevelwoo_cstitle_field'] ),
            'description'  => esc_html__( 'Shows next to Checkout button.', 'woocommerce' )
        )
    );
    // c.) settings 
    add_settings_field(
        'servlevelwoo_csdescription_field',
        esc_attr__('Instructions or other text', 'woocommerce'),
        'servlevelwoo_csdescription_field_cb',
        'servlevelwoo_options',
        'servlevelwoo_options_section',
        array( 
            'type'         => 'text',
            'option_group' => 'servlevelwoo_options', 
            'name'         => 'servlevelwoo_csdescription_field',
            'value'        => 
            esc_attr( get_option( 'servlevelwoo_options' )['servlevelwoo_csdescription_field'] ),
            'description'  => esc_html__( 'Shows below Cross Sell item in cart.', 'woocommerce' )
        )
    );
   
 
} 

/** 
 * name for 'branding' field
 * @since 1.0.0
 */
function servlevelwoo_cstitle_field_cb($args)
{  
   printf(
        '<input type="%1$s" name="%2$s[%3$s]" id="%2$s-%3$s" 
        value="%4$s" class="regular-text" />
        <span>%5$s <b class="wntip" title="tip"> ? </b></span>',
        $args['type'],
        $args['option_group'],
        $args['name'],
        $args['value'],
        $args['description']
    );
}

/** 
 * name for 'branding' field
 * @since 1.0.0
 */
function servlevelwoo_csdescription_field_cb($args)
{  
   printf(
        '<input type="%1$s" name="%2$s[%3$s]" id="%2$s-%3$s" 
        value="%4$s" class="regular-text" />
        <span>%5$s <b class="wntip" title="tip"> ? </b></span>',
        $args['type'],
        $args['option_group'],
        $args['name'],
        $args['value'],
        $args['description']
    );
}

/**
 ** Section Callbacks
 *  $id, $title, $callback, $page
 */
// section heading cb
function servlevelwoo_options_section_cb()
{    
print( '<hr>' );
} 


// d.) render admin page
function servlevelwoo_options_page() 
{
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) return;
    // check if the user have submitted the settings
    // wordpress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
    // add settings saved message with the class of "updated"
    add_settings_error( 'servlevelwoo_messages', 'servlevelwoo_message', 
                        esc_html__( 'Settings Saved', 'servlevelwoo' ), 'updated' );
    }
    // show error/update messages
    settings_errors( 'servlevelwoo_messages' );
     
    ?>
    <div class="wrap wrap-servlevelwoo-admin">
    
    <h1><span id="SlwOptions" class="dashicons dashicons-admin-tools"></span> 
    <?php echo esc_html( 'Admin' ); ?></h1>
         
    <form action="options.php" method="post">
    <?php //page=graphtowoo&tab=graphtowoo_options
        settings_fields(     'servlevelwoo_options' );
        do_settings_sections( 'servlevelwoo_options' ); 
        
        submit_button( 'Save Settings' ); 
 
    ?>
    </form>
    <h4>Instructions</h4>
    <p>Be sure all products have the Linked Products (Cross Sell) associated with the package that it requires.</p>
    <table width="450px" border="1" cellspacing="0" cellpadding="7"><tbody>
    <thead><tr><th>Product Required Package</th><th>Category | Linked Cross-Sell Req. Product(package)</th></tr></thead>
    <tr><td>Interactive </td><td>( security ) Smart Security Package</td></tr>
    <tr><td>Advanced Interactve </td><td>( access ) Smart Access Security Package</td></tr>
    <tr><td>Advanced Interactive (Comfort)</td><td>( comfort ) Smart Comfort Security Package</td></tr>
   <tr><td>Pro Video </td><td>( video ) Smart View Security Package</td></tr></tbody></table>
    <p>Add shortcode [servlevelwoo_view_orders] to Cart Page</p>
    <p>Required service level will be shown on the Cart Page next to the Checkout button.</p>
    </div>
<?php 
} 
