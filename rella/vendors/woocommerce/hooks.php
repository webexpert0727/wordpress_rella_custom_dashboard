<?php
/**
 * Themerella WooCommerce hooks
 *
 * @package rella-framework
 */
 

/**
 * Layout
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Loop
 * @see  rella_woocommere_headline()
 * @see  rella_woocommerce_template_loop_product_title()
 */
remove_action( 'woocommerce_before_shop_loop',           'woocommerce_result_count',                      20 );
remove_action( 'woocommerce_before_shop_loop',           'woocommerce_catalog_ordering',                  30 );
//remove_action( 'woocommerce_after_shop_loop',            'woocommerce_pagination',                        10 );
//add_action( 'woocommerce_before_shop_loop',              'rella_woocommere_headline',                     10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating',               5 );
remove_action( 'woocommerce_shop_loop_item_title',       'woocommerce_template_loop_product_title',       10 );
add_action( 'woocommerce_shop_loop_item_title',          'rella_woocommerce_template_loop_product_title', 10 );

/**
 * Loop List
 * @see rella_woocommerce_add_to_cart_list()
 */
add_action( 'woocommerce_shop_loop_add_cart_list', 'rella_woocommerce_add_to_cart_list', 10 );

/**
 * Loop carousel add to cart
 * @see rella_woocommerce_add_to_cart_carousel()
 */
add_action( 'rella_woocommerce_loop_add_to_cart_carousel', 'rella_woocommerce_add_to_cart_carousel', 10 );

/**
 * Loop elegant add to cart
 * @see rella_woocommerce_add_to_cart_elegant()
 */
add_action( 'rella_woocommerce_loop_add_to_cart_elegant', 'rella_woocommerce_add_to_cart_elegant', 10 );

/**
 * Product
 * @see  rella_woocommerce_template_single_cats()
 * @see  rella_woocommerce_variations_quantity_input()
 */
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash',         10 );
//remove_action( 'woocommerce_before_main_content',           'woocommerce_breadcrumb',                      20 );

//add_action( 'woocommerce_single_product_summary',       'woocommerce_template_single_title',            5 );
//add_action( 'woocommerce_single_product_price',         'woocommerce_template_single_price',           10 );
//add_action( 'rella_woocommerce_single_cats_tags',             'rella_woocommerce_template_single_cats',      10 );
//add_action( 'woocommerce_before_variations_form',           'rella_woocommerce_variations_quantity_input', 10 );
//remove_action( 'woocommerce_single_product_summary',       'woocommerce_template_single_meta',             5 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 25 );



/**
 * Filters
 * @see  rella_woocommerce_body_class()
 * @see  rella_products_per_page()
 * @see  rella_loop_columns()
 * @see  rella_wc_add_custom_query_var()
 * @see  rella_woocommerce_catalog_orderby()
 */
add_filter( 'body_class',                           'rella_woocommerce_body_class' );
add_filter( 'loop_shop_per_page',                   'rella_wc_limit_archive_posts_per_page', 20 );
add_filter( 'loop_shop_columns',                    'rella_loop_columns' );
add_filter( 'woocommerce_related_products_columns', 'rella_related_loop_columns', 10, 1 );
add_filter( 'woocommerce_up_sells_columns',         'rella_upsell_loop_columns', 10, 1 );
add_filter( 'query_vars',                           'rella_wc_add_custom_query_var' );
add_filter( 'woocommerce_catalog_orderby',          'rella_woocommerce_catalog_orderby' );

/**
 * Custom actions
 * @see  rella_woocommerce_setup()
 */
add_action( 'after_switch_theme', 'rella_woocommerce_setup', 1 );
add_action( 'init',               'rella_woocommerce_clear_cart_url' );

/**
 * Custom metaboxes for products in general tab
 * @see  rella_add_custom_general_fields()
 * @see  rella_add_custom_general_fields_save()
 */
add_action( 'woocommerce_product_options_general_product_data', 'rella_add_custom_general_fields' );
add_action( 'woocommerce_process_product_meta',                 'rella_add_custom_general_fields_save' );

/**
 * Custom fields for Product Categories
 * @see  rella_create_background_meta_field()
 * @see  rella_edit_background_meta_field()
 * @see  rella_save_tax_meta()
 * @see  rella_save_tax_meta()
 */
//add_action( 'product_cat_add_form_fields',  'rella_create_background_meta_field' );
//add_action( 'product_cat_edit_form_fields', 'rella_edit_background_meta_field' );
//add_action( 'edited_product_cat',           'rella_save_tax_meta' );
//add_action( 'create_product_cat',           'rella_save_tax_meta' );