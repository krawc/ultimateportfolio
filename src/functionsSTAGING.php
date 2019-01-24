<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// define('WPSCSS_THEME_DIR', get_stylesheet_directory());
//
// define('WP_SCSS_ALWAYS_RECOMPILE', true);

remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );

if (!session_id()) {
    session_start();
}
//Array with countries - for locations in WooCommerce and UM
$country_arr = array(
);

function artmo_country_input($field) {

  global $country_arr;

  $field['class'] 		= isset( $field['class'] ) ? $field['class'] : '';
  $field['value'] 		= isset( $field['value'] ) ? $field['value'] : '';
  $field['name'] 			= isset( $field['name'] ) ? $field['name'] : $field['id'];
  $field['placeholder_value'] = isset( $field['placeholder_value'] ) ? $field['placeholder_value'] : '--Select Country--';

  // Custom attribute handling
  $custom_attributes = array();

  if ( ! empty( $field['custom_attributes'] ) && is_array( $field['custom_attributes'] ) ) {
    foreach ( $field['custom_attributes'] as $attribute => $value ) {
      $custom_attributes[] = 'data-' . esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';

      // Required Option
      if( $attribute == 'required' ) {
        if( !isset( $field['custom_attributes']['required_message'] ) ) {
          $custom_attributes[] = 'data-required_message="' . esc_attr( $field['label'] ) . ': ' . __( 'This field is required.', 'wc-frontend-manager' ) . '"';
        }
        $field['label'] .= '<span class="required">*</span>';
      }
    }
  }

  // attribute handling
  $attributes = array();
  $is_multiple = false;
  if ( ! empty( $field['attributes'] ) && is_array( $field['attributes'] ) ) {
    foreach ( $field['attributes'] as $attribute => $value ) {
      $attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
    }
  }

  $options = '<option value="">' . __( $field['placeholder_value'], 'wc-frontend-manager' ) . '</option><optgroup label="-------------------------------------">';
  foreach ( $country_arr as $key => $value ) {
    if( $is_multiple || is_array( $field['value'] ) ) {
      $options .=  '<option value="' . esc_attr( $key ) . '"' . selected( in_array( $key, (array)$field['value'] ), true, false ) . '>' . esc_html( $value ) . '</option>';
    } else {
      $options .= '<option value="' . esc_attr( $key ) . '" ' . selected( esc_attr( $field['value'] ), esc_attr( $key ), false ) . '>' . esc_html($value) . '</option>';
    }
  }
  $options .= '</optgroup>';


  printf(
      '<select id="%s" name="%s" class="country_select %s" %s %s>%s</select>',
      esc_attr($field['id']),
      esc_attr($field['name']),
      esc_attr($field['class']),
      implode( ' ', $custom_attributes ),
      implode( ' ', $attributes ),
      $options
  );

}


// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
//enqueue child theme css
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_child_css', 100 );

// END ENQUEUE PARENT ACTION
function chld_thm_cfg_child_css() {
wp_enqueue_style( 'chld_thm_cfg_child', get_stylesheet_directory_uri() . '/css/style.css', array(  ) );
wp_enqueue_style( 'artmo-slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css' );
wp_enqueue_style( 'artmo_ionicons_master', get_stylesheet_directory_uri() . '/css/ionicons.min.css', array(  ) );
}
//enqueue child theme JS
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_child_script', 500 );

function chld_thm_cfg_child_script() {
wp_enqueue_script( 'infinitescroll', "https://cdnjs.cloudflare.com/ajax/libs/jquery-infinitescroll/2.0b2.120519/jquery.infinitescroll.min.js", array(), '20151215', true );
wp_enqueue_script( 'masonry', "https://cdnjs.cloudflare.com/ajax/libs/masonry/3.1.2/masonry.pkgd.js", array(), '20151215', true );
wp_enqueue_script( 'imagesloaded', "https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.0.4/jquery.imagesloaded.min.js", array(), '20151215', true );
wp_enqueue_script( 'artmo-slickjs', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array(), '20151215', true );
wp_enqueue_script( 'artmo-jquery-ui', get_stylesheet_directory_uri() . '/js/jquery-ui/jquery-ui.min.js', array(), '20151215', true );
wp_enqueue_script( 'artmo-jquery-tagthis', get_stylesheet_directory_uri() . '/js/jquery.tagthis.js', array(), '20151215', true );
wp_enqueue_script( 'artmo-script', get_stylesheet_directory_uri() . '/js/script.js', array(), '20151215', true );

wp_register_script( 'vantage-child-js', get_stylesheet_directory_uri() . '/js/script.js' );
$translation_array = array(
	'finishedMsg' => __( "No more artworks to load.", 'vantage-child' ),
  'msgText' => __( "loading artworks...", 'vantage-child' ),
  'seeOnWishlist' => __( "See on Wishlist", 'vantage-child' ),
  'wishlist' => __( 'Wishlist', 'vantage-child' ),
  'added' => __( 'Added!', 'vantage-child' ),
);
wp_localize_script( 'vantage-child-js', 'trans_object', $translation_array );
wp_enqueue_script( 'vantage-child-js' );

wp_enqueue_script( 'ajax-pagination',  get_stylesheet_directory_uri() . '/js/ajax-pagination.js', array(  ), '20151215', true );
wp_localize_script( 'ajax-pagination', 'ajaxpagination', array(
	'ajaxurl' => admin_url( 'admin-ajax.php' )
));
}



function wpb_add_google_fonts() {

wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css?family=Montserrat:400,700,300', false );
}

add_action( 'wp_enqueue_scripts', 'wpb_add_google_fonts' );


//shortcodes necessary due to incompatibility of UM with WPML
// add_shortcode("cn_profile_page_shortcodes","cn_profile_page_shortcodes");
// function cn_profile_page_shortcodes(){
//   $role = artmo_get_user_roles_by_id(um_profile_id());
//   $theRelevantRole = $role[0];
//   switch($theRelevantRole){
//   case "um_university":
//     echo do_shortcode('[ultimatemember form_id=41441]');
//     break;
// 	case "um_gallery":
// 	  echo do_shortcode('[ultimatemember form_id=28931]');
// 	  break;
// 	case "um_artist":
// 		echo do_shortcode('[ultimatemember form_id=29092]');
// 	  break;
// 	case "administrator":
// 		echo do_shortcode('[ultimatemember form_id=28939]');
// 	  break;
// 	case "um_member":
// 		echo do_shortcode('[ultimatemember form_id=25235]');
// 	  break;
//   case "um_team-artmo":
//     echo do_shortcode('[ultimatemember form_id=60822]');
//     break;
//   default:
//     echo print_r($role) . ' printed';
//     break;
//   }
// }

function artmo_array_contains($array, $value) {
  foreach ($array as $item) {
      foreach ($item as $key => $value) {
          if ($array[$key] = $value) {
            return true;
          }
      }
      return false;
  }
}


function artmo_get_user_roles_by_id( $id )
{
    $user = new WP_User( $id );
    if ( empty ( $user->roles ) or ! is_array( $user->roles ) )
        return array ();
    $wp_roles = new WP_Roles;
    $names    = $wp_roles->get_names();
    $out      = array ();
    $i        = 0;
    foreach ( $user->roles as $role )
    {
            $out[ $i ] = $role;
            $i++;
    }

    return $out;
}

remove_action( 'um_members_directory_footer', 'um_members_directory_pagination');
add_action( 'um_members_directory_footer', 'artmo_um_members_directory_pagination');

function artmo_um_members_directory_pagination( $args ) {
    $ultimatemember = new UM();
    extract( $args );
    if ( isset( $args['search'] ) && $args['search'] == 1 && isset( $args['must_search'] ) && $args['must_search'] == 1 && !isset( $_REQUEST['um_search'] ) )
        return;
    if ( um_members('total_pages') > 1 ) { // needs pagination
    ?>

    <div class="um-members-pagi um-artmo-pagi uimob340-hide uimob500-hide">
          <?php if ( um_members('page') != um_members('total_pages') ) { ?>
          <a href="<?php echo $ultimatemember->permalinks()->add_query( 'members_page', um_members('page') + 1 ); ?>" class="pagi pagi-arrow um-tip-n" title="<?php _e('Next', 'ultimatemember'); ?>"><?php _e('SEE MORE', 'ultimatemember'); ?></a>
          <?php } else { ?>
          <span class="pagi pagi-arrow disabled"><?php _e('No more pages to show', 'ultimatemember'); ?></span>
          <?php } ?>
    </div>
    <?php
    }
}


if (!class_exists('WCFM')) {
	// load Social if not already loaded
   //include_once(get_stylesheet_directory() . '/wc-frontend-manager/wc_frontend_manager.php');
   include_once(get_stylesheet_directory() . '/wc-frontend-manager-ultimate/wc_frontend_manager_ultimate.php');
}

//include_once(get_stylesheet_directory() . '/wc-multivendor-membership/wc-multivendor-membership.php');


remove_action( 'woocommerce_before_shop_loop_item','woocommerce_template_loop_product_link_open', 10 );
add_action ( 'woocommerce_before_shop_loop_item', 'ami_function_open_new_tab', 10 );

function ami_function_open_new_tab() {
  echo '<a target="_blank" href="' . get_the_permalink() . '" class="woocommerce-LoopProduct-link">';
}

// Add an "Ask a question" button & currency switcher

add_action( 'woocommerce_single_product_summary', 'my_extra_button_on_product_page', 19 );

function my_extra_button_on_product_page() {
  global $product;
  $price = $product->get_regular_price();
//  if (!empty($price)) {
    echo do_shortcode ('[woocs]');
//  }
}

//Remove additional info tab from products

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {
    global $product;
	  unset( $tabs['additional_information'] );
    return $tabs;
}

//Enable PHP custom code in text fields

add_filter('widget_text','execute_php',100);
function execute_php($html){
     if(strpos($html,"<"."?php")!==false){
          ob_start();
          eval("?".">".$html);
          $html=ob_get_contents();
          ob_end_clean();
     }
     return $html;
}

//Solve the "headers already sent" error by buffering the pages

//allow redirection, even if my theme starts to send output to the browser
add_action('init', 'do_output_buffer');
function do_output_buffer() {
        ob_start();
}

//Change order on product description

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 20 );

//Add function to display custom fields on single products:

function add_custom_fields_on_single_product(){

    global $woocommerce, $post, $product;

    $product_id = $post->ID;
    $author_id = $post->post_author;

    $size = $framed = '';

    $info_artist = array();
    $info_details = array();
    $info_size = array();

    $youTheArtist = get_post_meta($product_id, 'youTheArtist', true);
    $artistFirstName = get_post_meta($product_id, 'artistFirstName', true);
    $artistLastName = get_post_meta($product_id, 'artistLastName', true);
    $series = get_post_meta($product_id, 'series', true);
    $series_name = get_post_meta($product_id, 'series_name', true);
    $edition = get_post_meta($product_id, 'edition', true);
    $edition_no = get_post_meta($product_id, 'edition_no', true);
    $edition_t = get_post_meta($product_id, 'edition_t', true);
    $dimensions = get_post_meta($product_id, 'dimensions', true);
    $unique = get_post_meta($product_id, 'isUnique', true);
    $edition_number = 'Edition '.get_post_meta($product_id, 'editionNumber', true);
    $edition_total = get_post_meta($product_id, 'editionTotal', true);
    $in_a_frame = get_post_meta($product_id, 'inFrame', true);
    $framed_length = get_post_meta($product_id, 'framed_length', true);
    $framed_height = get_post_meta($product_id, 'framed_height', true);
    $length = get_post_meta($product_id, 'art_length', true);
    $width = get_post_meta($product_id, 'art_width', true);
    $height = get_post_meta($product_id, 'art_height', true);
    $artDescription = get_post_meta($product_id, 'artDescription', true);
    $artistCountry = get_user_meta($author_id, 'countryField', true);
    $year_produced = get_post_meta($product_id, 'year', true);
    $material_and_media = get_post_meta($product_id, 'materialMedia', true);
    $country_of_production = get_post_meta($product_id, 'countryProd', true);

    //specific rules

    //check if the artwork's publisher is the artist themself
    if ((!empty($artistFirstName)) && ($youTheArtist == 0)) {
      $first_name = $artistFirstName;
    } else {
      $first_name = get_post_meta($product_id, 'firstName', true);
    }

    //check if the artwork's publisher is the artist themself
    if ((!empty($artistLastName)) && ($youTheArtist == 0)) {
      $last_name = $artistLastName;
    } else {
      $last_name = get_post_meta($product_id, 'lastName', true);
    }

    $full_name = $first_name.' '.$last_name;

    if ((empty($country_of_production)) || ($country_of_production === $artistCountry)) {
      $country_of_production = '';
    }

    if ($edition == 1) {
      $edition_word = 'Edition '.$edition_no.' / '.$edition_t;
    }

    if (($length > 0) && ($height > 0)) {
      $size = $length.' x '.$height.__(' cm', 'vantage-child');
      $framed = __(' • Framed: ', 'vantage-child').$framed_length.' x '.$framed_height.__(' cm', 'vantage-child');
      //if the artwork is 3D
      if( $dimensions == 1) {
        $size = $length.' x '.$width.' x '.$height.__(' cm', 'vantage-child');
        $framed = '';
      }
    }

    //array for product_artist

    foreach (array($full_name, $artistCountry) as $value) {
      if(!empty($value))
        $info_artist[$value] = $value;
    }

    foreach (array($country_of_production, $year_produced, $material_and_media, $edition_word) as $value) {
      if(!empty($value))
        $info_details[$value] = $value;
    }

    $output = '';
    $output .= '<p class="woocommerce-product_artist">'.implode(' • ', $info_artist).'</p>';
    $output .= '<p class="woocommerce-product_details artwork_details">'.implode(' • ', $info_details).'</p>';
    $output .= '<p class="woocommerce-product_details artwork_size">'.$size;
    if ( ! $product->is_in_stock() )
      echo '<div class="stock out-of-stock">SOLD</div>';
    if (!empty($framed_length)) {
      $output .= $framed;
    }
    $output .= '</p>';
    $output .= '<p class="woocommerce-product_details artwork_description">'.$artDescription.'</p>';
    echo $output;

}

add_action( 'woocommerce_single_product_summary', 'add_custom_fields_on_single_product', 18 );

add_action( 'woocommerce_after_shop_loop_item_title', 'add_custom_fields_on_single_product', 5);


//Disable default Related Products section

function wc_remove_related_products( $args ) {
	return array();
}
add_filter('woocommerce_related_products_args','wc_remove_related_products', 10);

//Add HTML markup around breadcrumbs (to enable CSS edits)

function my_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => ' &#32; ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '<span>',
        'after'       => '</span>',
        'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
    );
}

add_filter( 'woocommerce_breadcrumb_defaults', 'my_woocommerce_breadcrumbs' );

//Display: product order at the bottom of the shop archive

function relocate_product_order() {

  remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
  //remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
  remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

  // add_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 6 );
  // add_action( 'woocommerce_after_shop_loop', 'wc_print_notices', 9 );
  // add_action( 'woocommerce_after_shop_loop', 'controls_row_open_div', 10 );
  // // add_action( 'woocommerce_after_shop_loop', 'custom_result_count', 11 );
  // add_action( 'woocommerce_after_shop_loop', 'controls_row_close_div', 14 );
  // add_action( 'woocommerce_after_shop_loop', 'add_pricefilter_shortcodes', 15 );

}



add_action ('init','relocate_product_order');
//

class Sorting_Filter extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname' => 'sorting_filter',
			'description' => 'Sorting Filter',
		);
		parent::__construct( 'sorting_filter', 'Sorting Filter for Products', $widget_ops );
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget
  //  WC()->woocommerce_catalog_ordering();
  if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
          return;
      }
      $orderby                 = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) ); // WPCS: sanitization ok, input var ok, CSRF ok.
      $show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
      $catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
          'menu_order' => __( 'Default sorting', 'woocommerce' ),
          'popularity' => __( 'Sort by popularity', 'woocommerce' ),
          'rating'     => __( 'Sort by average rating', 'woocommerce' ),
          'date'       => __( 'Sort by newness', 'woocommerce' ),
          'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
          'price-desc' => __( 'Sort by price: high to low', 'woocommerce' ),
      ) );

      if ( wc_get_loop_prop( 'is_search' ) ) {
          $catalog_orderby_options = array_merge( array( 'relevance' => __( 'Relevance', 'woocommerce' ) ), $catalog_orderby_options );
          unset( $catalog_orderby_options['menu_order'] );
          if ( 'menu_order' === $orderby ) {
              $orderby = 'relevance';
          }
      }

      if ( ! $show_default_orderby ) {
          unset( $catalog_orderby_options['menu_order'] );
      }

      if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
          unset( $catalog_orderby_options['rating'] );
      }

      wc_get_template( 'loop/orderby.php', array(
          'catalog_orderby_options' => $catalog_orderby_options,
          'orderby'                 => $orderby,
          'show_default_orderby'    => $show_default_orderby,
      ) );
	}

	public function form( $instance ) {
		// outputs the options form on admin
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}

// register Foo_Widget widget
function register_sorting_filter_widget() {
    register_widget( 'Sorting_Filter' );
}
add_action( 'widgets_init', 'register_sorting_filter_widget' );


//Add the new Product Gallery Compatibility

add_action( 'after_setup_theme', 'yourtheme_setup' );

function yourtheme_setup() {
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );


//Remove the default Woocommerce category/tag list

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'custom_product_meta_woocommerce', 40 );

function custom_product_meta_woocommerce(){
  if ( ! defined( 'ABSPATH' ) ) {
  	exit;
  }
  global $product;
  echo '<div class="product_meta">';
  do_action( 'woocommerce_product_meta_start' );

  $categories = get_the_terms( get_the_ID(), 'artists_cat' );
  $media_categories = get_the_terms( get_the_ID(), 'medium_cat' );
  $genre_tags = get_the_terms( get_the_ID(), 'genre_tag' );
  $theme_tags = get_the_terms( get_the_ID(), 'theme_tag' );
  $country_cat = get_the_terms( get_the_ID(), 'country_cat' );
  $color_tags = get_the_terms( get_the_ID(), 'color_tag' );

  $output = "";

  if ( $categories ) {
    $children = false;
    $childrenContent = '';

    foreach ($categories as $category) {
        if (!empty($category->parent)) {
          $children = true;
          $childrenContent .= '<span class="tagged_as"><a href="' . get_permalink( woocommerce_get_page_id( 'shop' ) ) . '?swoof=1&artists_cat=' . $category->slug . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '" > ' . $category->name.' </a></span>';
        }
    }

    if ($children === true) {
      $output .= '<div class="product-tax-section"><h3 class="product-tax-name">' . __('SERIES ', 'vantage-child') . '</h3>';
      $output .= '<div class="product-tax-list">';
      $output .= $childrenContent;
      $output .= '</div></div>';
    }
  }

  if ( $categories || $genre_tags || $country_cat ) {

    $output .= '<div class="product-tax-section"><h3 class="product-tax-name">' . __('CATEGORIES ', 'vantage-child') . '</h3>';
    $output .= '<div class="product-tax-list">';
    if( $categories ){
        foreach ($categories as $category) {
            if (empty($category->parent)) {
              $output .= '<span class="tagged_as"><a href="' . get_permalink( woocommerce_get_page_id( 'shop' ) ) . '?swoof=1&artists_cat=' . $category->slug . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '" > ' . $category->name.' </a></span>';
            }
        }
    }

    if( $media_categories ){
        foreach ($media_categories as $category) {
            $output .= '<span class="tagged_as"><a href="' . get_permalink( woocommerce_get_page_id( 'shop' ) ) . '?swoof=1&medium_cat=' . $category->slug . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '" > ' . $category->name.' </a></span>';
        }
    }

    if( $country_cat ){
        foreach ($country_cat as $category) {
            $output .= '<span class="tagged_as"><a href="' . get_permalink( woocommerce_get_page_id( 'shop' ) ) . '?swoof=1&country_cat=' . $category->name . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '" > ' . $category->name.' </a></span>';
        }
    }
    $output .= '</div></div>';
  }

  if( $genre_tags ){
    $output .= '<div class="product-tax-section"><h3 class="product-tax-name">' . __('GENRE ', 'vantage-child') . '</h3>';
    $output .= '<div class="product-tax-list">';
      foreach ($genre_tags as $category) {
          $output .= '<span class="tagged_as"><a href="' . get_permalink( woocommerce_get_page_id( 'shop' ) ) . '?swoof=1&genre_tag=' . $category->slug . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '" > ' . $category->name.' </a></span>';
      }
    $output .= '</div></div>';
  }

  if( $theme_tags ){
    $output .= '<div class="product-tax-section"><h3 class="product-tax-name">' . __('THEME ', 'vantage-child') . '</h3>';
    $output .= '<div class="product-tax-list">';
      foreach ($theme_tags as $category) {
          $output .= '<span class="tagged_as"><a href="' . get_permalink( woocommerce_get_page_id( 'shop' ) ) . '?swoof=1&theme_tag=' . $category->slug . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '" > ' . $category->name.' </a></span>';
      }
    $output .= '</div></div>';
  }

  if ( $color_tags ) {
    $output .= '<div class="product-tax-section"><h3 class="product-tax-name">' . __('COLORS ', 'vantage-child') . '</h3>';
    $output .= '<div class="product-tax-list">';
    foreach ($color_tags as $color) {
      $output .= '<div class="color-link" style="background-color: ' . strtolower($color->name) . ';"><a href="' . get_permalink( woocommerce_get_page_id( 'shop' ) ) . '?swoof=1&color_tag=' . $color->name . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $color->name ) ) . '" >'.$color->name.'</a></div>';
    }
    $output .= '</div></div>';
  }

  echo $output;

  // echo wc_get_product_term_list( $product->get_id(), 'artists_cat', ' ', '<span class="tagged_as">' . _n( '', '', count( wp_get_post_terms( $product->get_id(), 'artists_cat' ) ), 'woocommerce' ) . ' ', '</span>' );
  // echo wc_get_product_term_list( $product->get_id(), 'medium_cat', '', '<span class="tagged_as">' . _n( '', '', count( wp_get_post_terms( $product->get_id(), 'medium_cat' ) ), 'woocommerce' ) . '', '</span>' );
  // echo wc_get_product_term_list( $product->get_id(), 'genre_tag', '', '<span class="tagged_as">' . _n( '', '', count( wp_get_post_terms( $product->get_id(), 'genre_tag' ) ), 'woocommerce' ) . '', '</span>' );
  // echo wc_get_product_term_list( $product->get_id(), 'country_cat', '', '<span class="tagged_as">' . _n( '', '', count( wp_get_post_terms( $product->get_id(), 'country_cat' ) ), 'woocommerce' ) . '', '</span>' );
  do_action( 'woocommerce_product_meta_end' );
  echo '</div>';
}

//Add product description in cart

add_filter( 'woocommerce_get_item_data', 'wc_checkout_description_so_15127954', 10, 2 );

function wc_checkout_description_so_15127954( $other_data, $cart_item ){
    $_product = $cart_item['data'];
    $other_data[] = array( 'name' =>  '', 'value' => $_product->get_short_description() );
    return $other_data;
    var_dump($other_data);
}

// Remove variation stock data from product page display
function sww_wc_remove_variation_stock_display( $data ) {
    unset( $data['availability_html'] );
    return $data;
}
add_filter( 'woocommerce_available_variation', 'sww_wc_remove_variation_stock_display', 99 );

//Remove "sort by popularity"

add_filter( "woocommerce_catalog_orderby", "my_woocommerce_catalog_orderby", 20 );

function my_woocommerce_catalog_orderby( $orderby ) {
    unset($orderby["popularity"]);
    return $orderby;
}

//Woo Username displaying function

add_shortcode('profile_name', 'give_profile_name');

function give_profile_name(){

    $user=wp_get_current_user();
    $name=$user->user_firstname;
    $nickname=$user->display_name;

    if ( !empty($name) ) {
      return $name;
    } else if ( !empty($nickname) ) {
      return $nickname;
    } else {
      return 'YOUR PROFILE';
    }
}

add_filter( 'wp_nav_menu_objects', 'my_dynamic_menu_items' );

function my_dynamic_menu_items( $menu_items ) {
  foreach ( $menu_items as $menu_item ) {
    if ( '#profile_name# <i class="fa fa-user-o" aria-hidden="true"></i>' == $menu_item->title ) {
      global $shortcode_tags;
      if ( isset( $shortcode_tags['profile_name'] ) ) {
			  if (is_user_logged_in()){
          $menu_item->title = '<i class="fa fa-user-o" aria-hidden="true"></i> ' . call_user_func( $shortcode_tags['profile_name'] );
			  } else {
				  $menu_item->title = 'LOG IN';
			  }
      }
    }
  }
  return $menu_items;
}

//Add wishlist link to nav menu

add_shortcode('wishlist_link', 'add_last_nav_item');

function add_last_nav_item( $items, $args )
{
  $lists = WC_Wishlists_User::get_wishlists();
  $id = $lists[0]->id;
  if (!empty($lists)){
  $wishLink = get_home_url() . '/edit-my-list/?wlid=' . $id;
  } else{
	$wishLink = get_home_url() . "/my-wishlists/";
  }
  return '<a href="'.$wishLink.'">'.__('WISHLIST','vantage-child').'</a>';
}

//Add Search toggle
add_action( 'vantage_after_masthead', 'add_search_toggle_mobile' );

function add_search_toggle_mobile(){
  $search = '<div class="search-toggle-btn">';
  $search .= '<i class="fa fa-search" aria-hidden="true"></i>';
  $search .= '</div>';
  return $search;
}

//Increase the number of products displayed per archive page

add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
  $cols = 20;
  return $cols;
}

add_action( 'init', 'so_vantage_prevent_legacy' );

function so_vantage_prevent_legacy(){
	remove_action( 'save_post', 'vantage_panels_save_post', 5 );
}

//Open products in a new tab
add_filter( 'wc_product_table_open_products_in_new_tab', '__return_true' );

add_filter('loop_shop_columns', 'loop_columns');

if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 1; // 3 products per row
	}
}

add_action( 'init', 'vantage_remove_legacy_row_theme' );

function vantage_remove_legacy_row_theme() {
  remove_filter( 'siteorigin_panels_row_style_fields', 'vantage_panels_row_style_fields', 11 );
  remove_action( 'save_post', 'vantage_panels_save_post', 5, 2 );
}

//echo wp_next_scheduled('my_hourly_events');

if(!wp_next_scheduled('my_hourly_events'))
  wp_schedule_event(time(), 'hourly', 'my_hourly_events');

add_action('my_hourly_events', 'the_function_to_run');

function the_function_to_run(){

    //
    // $args = array(
    //     'orderby' => 'registered',
    //     'order' => 'ASC'
    //
    // );

    // The Query
    //$user_query = new WP_User_Query( $args );

    $user_query = get_users( array( 'fields' => array( 'ID' ) ) );

    $countries = array();
    $cities = array();

    $countriesGalleries = array();
    $citiesGalleries = array();

    $countriesArtists = array();
    $citiesArtists = array();

    $countriesUniversities = array();
    $citiesUniversties = array();
    $genres = array();
    //$series = array();

    if ( ! empty( $user_query ) ) {
    	foreach ( $user_query as $user ) {

        // $country = $user->countryField;
        // $city = $user->cityField;

        $country = get_user_meta($user->ID, 'countryField', true);
        $city = get_user_meta($user->ID, 'cityField', true);

        update_user_meta($user->ID, 'countrySearchOptions', $country);
        update_user_meta($user->ID, 'citySearchOptions', $city);

        $countries[$country] = $country;
        $cities[$city] = $city;
        // $ultimatemember = new UM();
        // um_fetch_user( $user->ID );
        $role = artmo_get_user_roles_by_id( $user->ID );

        if ( $role[0] === 'um_gallery' ) {
            update_user_meta($user->ID, 'galleryCountrySearchOptions', $country);
            update_user_meta($user->ID, 'galleryCitySearchOptions', $city);
            $countriesGalleries[$country] = $country;
            $citiesGalleries[$city] = $city;
        }

        if ( $role[0] === 'um_artist' ) {
            update_user_meta($user->ID, 'artistCountrySearchOptions', $country);
            update_user_meta($user->ID, 'artistCitySearchOptions', $city);
            $countriesArtists[$country] = $country;
            $citiesArtists[$city] = $city;
            //get artist's products
            $args = array(
                'post_type'  => 'product',
                'author'     => $user->ID,
            );
            $wp_posts = get_posts($args);
            $contents = '';
            $user_tags = array();
            //if has products, add tags as user meta
            if (count($wp_posts)) {
              foreach ( $wp_posts as $post ) :
                $post_id = $post->ID;
                $genreTags = wp_get_post_terms($post_id, 'genre_tag');
                $media = wp_get_post_terms($post_id, 'medium_cat');
                foreach ($genreTags as $cat) {
                  $genres[$cat->name] = $cat->name;
                  $user_tags[$cat->name] = $cat->name;
                }
                foreach ($media as $cat) {
                  $genres[$cat->name] = $cat->name;
                  $user_tags[$cat->name] = $cat->name;
                }
              endforeach;
              update_user_meta($user->ID, 'genres', $user_tags);
            } else {
              update_user_meta($user->ID, 'genres', array());
            }
        }

        if ( $role[0] === 'um_university' ) {
            update_user_meta($user->ID, 'universityCountrySearchOptions', $country);
            update_user_meta($user->ID, 'universityCitySearchOptions', $city);
            $countriesUniversities[$country] = $country;
            $citiesUniversities[$city] = $city;
        }
      }
      ksort($genres);
      ksort($countries);
      ksort($cities);
      ksort($countriesGalleries);
      ksort($citiesGalleries);
      ksort($countriesArtists);
      ksort($citiesArtists);
      ksort($countriesUniversities);
      ksort($citiesUniversities);
    } else {
      echo 'No users to show.';
    }

   update_option( 'used_genres', $genres);
   update_option( 'used_genres', $genres);

   update_option( 'used_countries', $countries);
   update_option( 'used_cities', $cities);

   update_option( 'used_countries_galleries', $countriesGalleries);
   update_option( 'used_cities_galleries', $citiesGalleries);

   update_option( 'used_countries_artists', $countriesArtists);
   update_option( 'used_cities_artists', $citiesArtists);

   update_option( 'used_countries_universities', $countriesUniversities);
   update_option( 'used_cities_universities', $citiesUniversities);

}

function get_all_genres() {
  $allGenres = get_option('used_genres');
  return $allGenres;
}

function get_all_countries() {
  $allCountries = get_option('used_countries');
  return $allCountries;
}

function get_all_cities() {
  $allCities = get_option('used_cities');
  return $allCities;
}

function get_galleries_countries() {
  $allCountriesGalleries = get_option('used_countries_galleries');
  return $allCountriesGalleries;
}

function get_galleries_cities() {
  $allCitiesGalleries = get_option('used_cities_galleries');
  return $allCitiesGalleries;
}

function get_artists_countries() {
  $allCountriesArtists = get_option('used_countries_artists');
  return $allCountriesArtists;
}

function get_artists_cities() {
  $allCitiesArtists = get_option('used_cities_artists');
  return $allCitiesArtists;
}

function get_universities_countries() {
  $allCountriesUniversities = get_option('used_countries_universities');
  return $allCountriesUniversities;
}

function get_universities_cities() {
  $allCitiesUniversities = get_option('used_cities_universities');
  return $allCitiesUniversities;
}

//echo print_r( get_users( array( 'fields' => array( 'ID' ) ) ) );

add_action( 'added_post_meta', 'mp_sync_on_product_save_update_meta', 10, 4 );

function mp_sync_on_product_save_update_meta( $meta_id, $post_id, $meta_key, $meta_value ) {
    if ( get_post_type( $post_id ) == 'product' ) { // we've been editing a product
        $product = wc_get_product( $post_id );

        $author_id = $product->post_author;

        $length = get_post_field( 'art_length', $post_id);
        $width = get_post_field( 'art_width', $post_id);
        $height = get_post_field( 'art_height', $post_id);

        $in_a_frame = get_post_field('inFrame', $post_id);
        $countryProd = get_post_field('countryProd', $post_id);

        $country = get_user_meta($author_id, 'countryField', true);

        $framed_length = get_post_field( 'framed_length', $post_id);
        $framed_width = get_post_field( 'framed_width', $post_id);
        $framed_height = get_post_field( 'framed_height', $post_id);

        if ( $in_a_frame == '1' ) {
          update_post_meta($post_id, '_length', $framed_length);
          update_post_meta($post_id, '_width', $framed_width);
          update_post_meta($post_id, '_height', $framed_height);
        } else {
          update_post_meta($post_id, '_length', $length);
          update_post_meta($post_id, '_width', $width);
          update_post_meta($post_id, '_height', $height);
        }
        $author = get_post_field( 'post_author', $post_id);
        $authordata = get_userdata($author);
        $first_n = $authordata->first_name;
        $last_n = $authordata->last_name;
        //
        // $youTheArtist = get_post_meta($post_id, 'youTheArtist', true);
        //
        // if ((isset($youTheArtist)) && (!empty($youTheArtist))) {

        update_post_meta($post_id, 'firstName', $first_n);
        update_post_meta($post_id, 'lastName', $last_n);
        $artist_category = get_term_by('slug', 'artist_'.$author, 'artists_cat' );
        $artist_term = array( $artist_category->term_id );
        //
        // um_fetch_user( $user_id );
        // $role = artmo_get_user_roles_by_id( $user_id );
        // $theRelevantRole = $role[0];
        //
        // if ( $theRelevantRole == 'um_artist' ) {

        if(empty($countryProd)) {
          $countryProd = $country;
        }

        um_fetch_user( $author_id );
        $role = artmo_get_user_roles_by_id( $author_id );
        $theRelevantRole = $role[0];
        $display_name = um_user('display_name');
        $user_login = um_user('user_login');

        if (empty(um_user('user_login'))) {
          $display_name = $user_id;
          $user_login = $user_id;
        }

        // wp_set_post_terms( $post_id, $artist_term, 'artists_cat' );
        // wp_set_post_terms( $post_id, $countryProd, 'country_cat' );

        //wp_set_object_terms( $post_id, (int)$author_id, WC_PRODUCT_VENDORS_TAXONOMY );


        //}

        // } else {
        //
        //   $artistFirstName = get_post_meta($post_id, 'artistFirstName', true);
        //   $artistLastName = get_post_meta($post_id, 'artistLastName', true);
        //   update_post_meta($post_id, 'firstName', $artistFirstName);
        //   update_post_meta($post_id, 'lastName', $artistLastName);
        //
        //   if (!metadata_exists( 'product', $post_id, 'otherArtistID' )) {
        //     $display_name = $artistFirstName . ' ' . $artistLastName;
        //     $random_no = mt_rand(100000000,999999999);
        //     $otherArtistID = update_post_meta( $post_id, 'otherArtistID', $random_no );
        //     $newCategory = wp_insert_term(
        //       $display_name,   // the term
        //       'artists_cat', // the taxonomy
        //       array(
        //         'description' => '',
        //         'slug'        => 'artist_'.$random_no
        //       )
        //     );
        //     $artist_term = array( $newCategory->term_id );
        //     wp_set_post_terms( $post_id, (int)$artist_term, 'artists_cat' );
        //     wp_set_post_terms( $post_id, $countryProd, 'country_cat' );
        //   } else {
        //     $otherArtistID = get_post_meta($post_id, 'otherArtistID', true);
        //     $artist_category = get_term_by('slug', 'artist_'.$otherArtistID, 'artists_cat' );
        //     $artist_term = array( $artist_category->term_id );
        //     wp_set_post_terms( $post_id, (int)$artist_term, 'artists_cat' );
        //     wp_set_post_terms( $post_id, $countryProd, 'country_cat' );
        //   }
        // }
    }
}

add_action('template_redirect', 'collection_link');
function collection_link(){
  if (isset($_GET["collection_link"])) {
    $user_id = get_current_user_id();
    $registered = get_user_meta($user_id, 'registered_vendor', true);
    $um_user = um_fetch_user($user_id);
    $profile_url = um_user_profile_url();
    if(empty($registered)) {
      ?>
      <script type="text/javascript">
        window.location.href = "<?php echo $profile_url;?>/vendor-membership"
      </script>
      <?php
    } else {
      ?>
      <script type="text/javascript">
        window.location.href = "<?php echo get_home_url(); ?>/wcfm"
      </script>
      <?php
    }
  }
}

function get_collection_menu_link() {
  $ultimatemember = new UM();
  um_fetch_user( $user_id );
  $role = artmo_get_user_roles_by_id( $user_id );
  if (( artmo_array_contains($role, 'um_artist')  ) || ( artmo_array_contains($role, 'um_artist') )) {
    return '<a class="collection_menu_link" href="/?collection_link">' . __('COLLECTION', 'vantage-child') . '</a>';
  }
}

add_shortcode('get_collection_menu_link', 'get_collection_menu_link');

add_action('wcfmmp_new_store_created', 'add_new_vendor_account', get_current_user_id());
function add_new_vendor_account($user_id){

  $registered = get_user_meta($user_id, 'registered_vendor', true);

  if(empty($registered)) {

      $ultimatemember = new UM();

      um_fetch_user( $user_id );
      // $role = artmo_get_user_roles_by_id( $user_id );
      // $theRelevantRole = $role[0];
      $display_name = um_user('display_name');
      $user_login = um_user('user_login');


      if (empty(um_user('user_login'))) {
        $display_name = $user_id;
        $user_login = $user_id;
      }

      // Getting the WP_User object
      $user->add_role( 'um_artist' );

      //if ( $theRelevantRole == 'um_artist' ) {

          if ( ! is_wp_error( $term ) ) {

            wp_insert_term(
              $display_name,   // the term
              'artists_cat', // the taxonomy
              array(
                'description' => '',
                'slug'        => 'artist_'.$user_id
              )
            );

            add_user_meta($user_id, 'registered_vendor', 'true', true);

        } else {
          echo '<pre>'.var_dump($term->get_error_messages()).'</pre>';
        }
      //}
    }
}

add_filter( 'um_profile_menu_link_collection', 'collection_profile_link' );

function collection_profile_link() {
  $user_id = get_current_user_id();
  $registered = get_user_meta($user_id, 'registered_vendor', true);
  if(empty($registered)) {
    return 'https://www.artmo.com/user?modal-link=terms-and-conditions-form';
  } else {
    return 'https://www.artmo.com/wcfm';
  }
}

add_action('vantage_before_footer', 'loader_overlay');

function loader_overlay() {?>
  <div class="overlay" id="processing">
    <div class="overlay-modal">
      <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
      <span class="sr-only">Loading...</span>
      <p class="processing">Processing...</p>
    </div>
  </div>
<?php }

add_filter('wcfm_allwoed_user_rols', 'return_user_roles_wcfm');

function return_user_roles_wcfm() {
  return array( 'administrator', 'shop_manager', 'um_artist' );
}

add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {

	// Adds the new tab
  $artist_id = get_the_author_meta( 'ID' );
  $display_name = get_user_meta($artist_id, 'user_display_name', true);

  $args = array(
      'post_type' => 'product',
      'posts_per_page' => 8,
      'author' => $artist_id
  );
  $query = new WP_Query( $args );
  $count = $query->post_count;

  if( ($query->have_posts()) && ($count >= 3)) :
  	$tabs['more_artworks'] = array(
  		'title' 	=> sprintf(__( 'More artworks from %s', 'woocommerce' ), $display_name),
  		'priority' 	=> 50,
  		'callback' 	=> 'woo_more_products_tab'
  	);
  endif;

  $tabs['about_artist'] = array(
    'title' 	=> sprintf(__( 'About %s', 'woocommerce' ), $display_name),
    'priority' 	=> 50,
    'callback' 	=> 'woo_author_meta_tab'
  );

  $tabs['shipping_policy'] = array(
    'title' 	=> sprintf(__( 'Shipping Policy', 'woocommerce' ), $display_name),
    'priority' 	=> 50,
    'callback' 	=> 'woo_author_shipping_policy'
  );

	return $tabs;
}

function woo_author_shipping_policy() {
  $prod_id = get_the_ID();
  $artist_id = get_the_author_meta( 'ID' );
  $artist_shipping_policy = get_user_meta($artist_id, 'shipping_policy', true);
  $content = '';
  if (!empty($artist_shipping_policy)) {
    $content .= '<div class="note-from-seller">';
    $content .= get_user_meta($artist_id, 'shipping_policy', true);
    $content .= '</div>';
  }
  $content .= get_theme_mod('global_shipping_policy');
  echo $content;
}

function woo_more_products_tab() {

  $prod_id = get_the_ID();
  $artist_id = get_the_author_meta( 'ID' );
  $cats = get_the_category();
  $artist_category_link = get_term_link('artist_'.$artist_id, 'artists_cat' );
  $args = array(
      'post_type' => 'product',
      'posts_per_page' => 8,
      'author' => $artist_id,
      'orderby' => 'rand'
  );
  $query = new WP_Query( $args );
  ?>

  <div class="products_slick">
    <?php if( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post();
    $product = wc_get_product( get_the_ID() );?>
      <div class="slick-singleProduct">
        <a href="<?php the_permalink();?>">
          <div class="slick-singleProduct_thumb">
            <img class="thumbImage" src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>">
          </div>
          <div class="slick-singleProduct-info">
            <p><?php the_title(); ?></p>
            <p> <?php echo $product->get_price_html(); ?></p>
          </div>
        </a>
      </div>
      <?php endwhile; endif; wp_reset_postdata();?>

  </div>
<?php
}

function woo_author_meta_tab() {

  $ultimatemember = new UM();
  $my_home_url = apply_filters( 'wpml_home_url', get_option( 'home' ) );
  $prod_id = get_the_ID();
  $artist_id = get_the_author_meta( 'ID' );
  um_fetch_user($artist_id);
  $artist_login = sanitize_title( um_user('user_login') );
  $artist_first_name = um_user('first_name');
  $artist_last_name = um_user('last_name');
	$artist_name = $artist_first_name.' '.$artist_last_name;
  $artist_avatar = um_get_avatar_uri( um_profile('profile_photo'), 250 );?>
    <div class="artist_info">
      <h4><?php echo __('About ', 'vantage-child') . $artist_name; ?></h4>
      <div class="artist-profilePic">
        <img class="artist-profilePic-img" src="<?php echo $artist_avatar; ?>"/>
      </div>
      <div class="artist_meta">
        <div class="artist_meta-content"><?php echo um_user('text_field');?></div>
        <div class="profile-link">
          <a target="_blank" href="<?php echo $my_home_url.'/user/'.$artist_login; ?>"><?php _e('GO TO PROFILE', 'vantage-child'); ?></a>
        </div>
      </div>
    </div>
  <?php
}

add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
	function wcs_woo_remove_reviews_tab($tabs) {
	unset($tabs['reviews']);
  unset($tabs['description']);
	return $tabs;
}

add_action('init', 'wpse_74054_add_author_woocommerce', 999 );
function wpse_74054_add_author_woocommerce() {
    add_post_type_support( 'product', 'author' );
}

if ( ! function_exists( 'artist_register_tax' ) ) {

// Register Custom Taxonomy
function artist_register_tax() {

	$labels = array(
		'name'                       => _x( 'Artists', 'Taxonomy General Name', 'vantage-child' ),
		'singular_name'              => _x( 'Artist', 'Taxonomy Singular Name', 'vantage-child' ),
		'menu_name'                  => __( 'Artist Categories', 'vantage-child' ),
		'all_items'                  => __( 'All Artist Categories', 'vantage-child' ),
		'parent_item'                => __( 'Parent Artist Category', 'vantage-child' ),
		'parent_item_colon'          => __( 'Parent Artist Category:', 'vantage-child' ),
		'new_item_name'              => __( 'New Artist Category', 'vantage-child' ),
		'add_new_item'               => __( 'Add New Artist Category', 'vantage-child' ),
		'edit_item'                  => __( 'Edit Artist Category', 'vantage-child' ),
		'update_item'                => __( 'Update Artist Category', 'vantage-child' ),
		'view_item'                  => __( 'View Artist Category', 'vantage-child' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'vantage-child' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'vantage-child' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'vantage-child' ),
		'popular_items'              => __( 'Popular Items', 'vantage-child' ),
		'search_items'               => __( 'Search Artist Categories', 'vantage-child' ),
		'not_found'                  => __( 'Not Found', 'vantage-child' ),
		'no_terms'                   => __( 'No categories', 'vantage-child' ),
		'items_list'                 => __( 'Categories list', 'vantage-child' ),
		'items_list_navigation'      => __( 'Artist categories list navigation', 'vantage-child' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'artists_cat', array( 'product' ), $args );

}
add_action( 'init', 'artist_register_tax', 0 );

}

if ( ! function_exists( 'country_cat_register_tax' ) ) {

// Register Custom Taxonomy
function country_cat_register_tax() {

	$labels = array(
		'name'                       => _x( 'Country Category', 'Taxonomy General Name', 'vantage-child' ),
		'singular_name'              => _x( 'Country Category', 'Taxonomy Singular Name', 'vantage-child' ),
		'menu_name'                  => __( 'Country Categories', 'vantage-child' ),
		'all_items'                  => __( 'All Country Categories', 'vantage-child' ),
		'parent_item'                => __( 'Parent Country Category', 'vantage-child' ),
		'parent_item_colon'          => __( 'Parent Country Category:', 'vantage-child' ),
		'new_item_name'              => __( 'New Country Category', 'vantage-child' ),
		'add_new_item'               => __( 'Add New Country Category', 'vantage-child' ),
		'edit_item'                  => __( 'Edit Country Category', 'vantage-child' ),
		'update_item'                => __( 'Update Country Category', 'vantage-child' ),
		'view_item'                  => __( 'View Country Category', 'vantage-child' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'vantage-child' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'vantage-child' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'vantage-child' ),
		'popular_items'              => __( 'Popular Items', 'vantage-child' ),
		'search_items'               => __( 'Search Country Categories', 'vantage-child' ),
		'not_found'                  => __( 'Not Found', 'vantage-child' ),
		'no_terms'                   => __( 'No categories', 'vantage-child' ),
		'items_list'                 => __( 'Categories list', 'vantage-child' ),
		'items_list_navigation'      => __( 'Country categories list navigation', 'vantage-child' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'country_cat', array( 'product' ), $args );
}
add_action( 'init', 'country_cat_register_tax', 0 );
}

if ( ! function_exists( 'color_tag_register_tax' ) ) {

// Register Custom Taxonomy
function color_tag_register_tax() {

	$labels = array(
		'name'                       => _x( 'Colors', 'Taxonomy General Name', 'vantage-child' ),
		'singular_name'              => _x( 'Colors', 'Taxonomy Singular Name', 'vantage-child' ),
		'menu_name'                  => __( 'Colors', 'vantage-child' ),
		'all_items'                  => __( 'All Colors', 'vantage-child' ),
		'parent_item'                => __( 'Colors', 'vantage-child' ),
		'parent_item_colon'          => __( 'Colors:', 'vantage-child' ),
		'new_item_name'              => __( 'New Color', 'vantage-child' ),
		'add_new_item'               => __( 'Add New Color', 'vantage-child' ),
		'edit_item'                  => __( 'Edit Color', 'vantage-child' ),
		'update_item'                => __( 'Update Color', 'vantage-child' ),
		'view_item'                  => __( 'View Color', 'vantage-child' ),
		'separate_items_with_commas' => __( 'Separate Color', 'vantage-child' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'vantage-child' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'vantage-child' ),
		'popular_items'              => __( 'Popular Colors', 'vantage-child' ),
		'search_items'               => __( 'Search Colors', 'vantage-child' ),
		'not_found'                  => __( 'Not Found', 'vantage-child' ),
		'no_terms'                   => __( 'No categories', 'vantage-child' ),
		'items_list'                 => __( 'Colors list', 'vantage-child' ),
		'items_list_navigation'      => __( 'Colors list navigation', 'vantage-child' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'color_tag', array( 'product' ), $args );
}
add_action( 'init', 'color_tag_register_tax', 0 );
}


if ( ! function_exists( 'medium_cat_register_tax' ) ) {

// Register Custom Taxonomy
function medium_cat_register_tax() {

	$labels = array(
		'name'                       => _x( 'Art Media Category *', 'Taxonomy General Name', 'vantage-child' ),
		'singular_name'              => _x( 'Art Media Categories', 'Taxonomy Singular Name', 'vantage-child' ),
		'menu_name'                  => __( 'Art Media Categories', 'vantage-child' ),
		'all_items'                  => __( 'All Art Media Categories', 'vantage-child' ),
		'parent_item'                => __( 'Parent Art Media Category', 'vantage-child' ),
		'parent_item_colon'          => __( 'Parent Art Media Category:', 'vantage-child' ),
		'new_item_name'              => __( 'New Art Media Category', 'vantage-child' ),
		'add_new_item'               => __( 'Add New Art Media Category', 'vantage-child' ),
		'edit_item'                  => __( 'Edit Art Media Category', 'vantage-child' ),
		'update_item'                => __( 'Update Art Media Category', 'vantage-child' ),
		'view_item'                  => __( 'View Art Media Category', 'vantage-child' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'vantage-child' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'vantage-child' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'vantage-child' ),
		'popular_items'              => __( 'Popular Items', 'vantage-child' ),
		'search_items'               => __( 'Search Art Media Categories', 'vantage-child' ),
		'not_found'                  => __( 'Not Found', 'vantage-child' ),
		'no_terms'                   => __( 'No categories', 'vantage-child' ),
		'items_list'                 => __( 'Categories list', 'vantage-child' ),
		'items_list_navigation'      => __( 'Art Media categories list navigation', 'vantage-child' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'medium_cat', array( 'product' ), $args );

  }
  add_action( 'init', 'medium_cat_register_tax', 0 );
}

if ( ! function_exists( 'genre_tag_register_tax' ) ) {
  // Register Custom Taxonomy
  function genre_tag_register_tax() {

  	$labels = array(
  		'name'                       => _x( 'Genre Tag', 'Taxonomy General Name', 'vantage-child' ),
  		'singular_name'              => _x( 'Genre Tag', 'Taxonomy Singular Name', 'vantage-child' ),
  		'menu_name'                  => __( 'Genre Tags', 'vantage-child' ),
  		'all_items'                  => __( 'All Genre Tags', 'vantage-child' ),
  		'parent_item'                => __( 'Parent Genre Tag', 'vantage-child' ),
  		'parent_item_colon'          => __( 'Parent Genre Tag:', 'vantage-child' ),
  		'new_item_name'              => __( 'New Genre Tag', 'vantage-child' ),
  		'add_new_item'               => __( 'Add New Genre Tag', 'vantage-child' ),
  		'edit_item'                  => __( 'Edit Genre Tag', 'vantage-child' ),
  		'update_item'                => __( 'Update Genre Tag', 'vantage-child' ),
  		'view_item'                  => __( 'View Genre Tag', 'vantage-child' ),
  		'separate_items_with_commas' => __( 'Separate items with commas', 'vantage-child' ),
  		'add_or_remove_items'        => __( 'Add or remove items', 'vantage-child' ),
  		'choose_from_most_used'      => __( 'Choose from the most used', 'vantage-child' ),
  		'popular_items'              => __( 'Popular Items', 'vantage-child' ),
  		'search_items'               => __( 'Search Genre Tags', 'vantage-child' ),
  		'not_found'                  => __( 'Not Found', 'vantage-child' ),
  		'no_terms'                   => __( 'No Genre Tags', 'vantage-child' ),
  		'items_list'                 => __( 'Genre Tags list', 'vantage-child' ),
  		'items_list_navigation'      => __( 'Genre Tags list navigation', 'vantage-child' ),
  	);
  	$args = array(
  		'labels'                     => $labels,
  		'hierarchical'               => false,
  		'public'                     => true,
  		'show_ui'                    => true,
  		'show_admin_column'          => true,
  		'show_in_nav_menus'          => true,
  		'show_tagcloud'              => true,
  		'show_in_rest'               => true,
  	);
  	register_taxonomy( 'genre_tag', array( 'product' ), $args );
  }
  add_action( 'init', 'genre_tag_register_tax', 0 );
}

if ( ! function_exists( 'theme_tag_register_tax' ) ) {
  // Register Custom Taxonomy
  function theme_tag_register_tax() {

  	$labels = array(
  		'name'                       => _x( 'Theme Tag', 'Taxonomy General Name', 'vantage-child' ),
  		'singular_name'              => _x( 'Theme Tag', 'Taxonomy Singular Name', 'vantage-child' ),
  		'menu_name'                  => __( 'Theme Tags', 'vantage-child' ),
  		'all_items'                  => __( 'All Theme Tags', 'vantage-child' ),
  		'parent_item'                => __( 'Parent Theme Tag', 'vantage-child' ),
  		'parent_item_colon'          => __( 'Parent Theme Tag:', 'vantage-child' ),
  		'new_item_name'              => __( 'New Theme Tag', 'vantage-child' ),
  		'add_new_item'               => __( 'Add New Theme Tag', 'vantage-child' ),
  		'edit_item'                  => __( 'Edit Theme Tag', 'vantage-child' ),
  		'update_item'                => __( 'Update Theme Tag', 'vantage-child' ),
  		'view_item'                  => __( 'View Theme Tag', 'vantage-child' ),
  		'separate_items_with_commas' => __( 'Separate items with commas', 'vantage-child' ),
  		'add_or_remove_items'        => __( 'Add or remove items', 'vantage-child' ),
  		'choose_from_most_used'      => __( 'Choose from the most used', 'vantage-child' ),
  		'popular_items'              => __( 'Popular Themes', 'vantage-child' ),
  		'search_items'               => __( 'Search Theme Tags', 'vantage-child' ),
  		'not_found'                  => __( 'Not Found', 'vantage-child' ),
  		'no_terms'                   => __( 'No Theme Tags', 'vantage-child' ),
  		'items_list'                 => __( 'Theme Tags list', 'vantage-child' ),
  		'items_list_navigation'      => __( 'Theme Tags list navigation', 'vantage-child' ),
  	);
  	$args = array(
  		'labels'                     => $labels,
  		'hierarchical'               => false,
  		'public'                     => true,
  		'show_ui'                    => true,
  		'show_admin_column'          => true,
  		'show_in_nav_menus'          => true,
  		'show_tagcloud'              => true,
  		'show_in_rest'               => true,
  	);
  	register_taxonomy( 'theme_tag', array( 'product' ), $args );
  }
  add_action( 'init', 'theme_tag_register_tax', 0 );
}



add_action( 'customize_register', 'mytheme_customize_register' );

function mytheme_customize_register( $wp_customize ) {

  class Text_Editor_Custom_Control extends WP_Customize_Control
  {
        /**
         * Render the content on the theme customizer page
         */
        public function render_content()
         {
              ?>
              <label>
              <span class="customize-text_editor"><?php echo esc_html( $this->label ); ?></span>
              <?php $settings = array(
                        'textarea_name' => $this->id
                    );
                    wp_editor($this->value(), $this->id, $settings ); ?>
              </label>
              <?php
         }
  }

  $wp_customize->add_section( 'global_admin_texts' , array(
    'title'      => __( 'ARTMO Global Admin Texts', 'vantage-child' ),
    'priority'   => 30,
  ) );

  $wp_customize->add_setting( 'vendor_notice' , array(
	 'default'   => '',
	 'transport' => 'refresh',
	) );

  $wp_customize->add_setting( 'global_shipping_policy' , array(
   'default'   => '',
   'transport' => 'refresh',
  ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'vendor_notice', array(
    'label'      => __( 'Notice to Vendors', 'vantage-child' ),
    'section'    => 'global_admin_texts',
    'settings'   => 'vendor_notice',
    'type' => 'textarea'
  ) ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'global_shipping_policy', array(
    'label'      => __( 'Shipping Policy', 'vantage-child' ),
    'section'    => 'global_admin_texts',
    'settings'   => 'global_shipping_policy',
    'type' => 'textarea'
  ) ) );

}



function artmo_display_notice_box_dashboard() {
  if (get_theme_mod('vendor_notice')){
    ?>
  <div class="wcfm_vendor_notice">
    <p class="wcfm_vendor_notice_text"><?php echo get_theme_mod('vendor_notice'); ?></p>
  </div>
<?php
  }
}

add_action('wcfm_before_dashboard_welcome_box', 'artmo_display_notice_box_dashboard');

//Page Slug Body Class
function add_slug_body_class( $classes ) {
  global $wp, $post;
  if ( isset( $post ) ) {
    $url = home_url( $wp->request );
    $end = end(explode('/', $url));
    $end = array_slice(explode('/', $url), -1)[0];
    $classes[] = $post->post_type . '-' . $post->post_name . ' ' . $end;
  }
  return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

/**
 * Register the stylesheets for the public-facing side of the site.
 * @since    0.5
 */
add_action( 'wp_enqueue_scripts', 'sl_enqueue_scripts' );
function sl_enqueue_scripts() {
	wp_enqueue_script( 'simple-likes-public-js', get_stylesheet_directory_uri() . '/js/simple-likes-public.js', array( 'jquery' ), '0.5', false );
	wp_localize_script( 'simple-likes-public-js', 'simpleLikes', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'like' => __( 'Like', 'vantage-child' ),
		'unlike' => __( 'Unlike', 'vantage-child' )
	) );
}

add_action( 'wp_ajax_nopriv_process_simple_like', 'process_simple_like' );
add_action( 'wp_ajax_process_simple_like', 'process_simple_like' );
function process_simple_like() {
	// Security
	$nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( $_REQUEST['nonce'] ) : 0;
	if ( !wp_verify_nonce( $nonce, 'simple-likes-nonce' ) ) {
		exit( __( 'Not permitted', 'YourThemeTextDomain' ) );
	}
	// Test if javascript is disabled
	$disabled = ( isset( $_REQUEST['disabled'] ) && $_REQUEST['disabled'] == true ) ? true : false;
	// Test if this is a comment
	$is_comment = ( isset( $_REQUEST['is_comment'] ) && $_REQUEST['is_comment'] == 1 ) ? 1 : 0;
	// Base variables
	$post_id = ( isset( $_REQUEST['post_id'] ) && is_numeric( $_REQUEST['post_id'] ) ) ? $_REQUEST['post_id'] : '';
	$result = array();
	$post_users = NULL;
	$like_count = 0;
	// Get plugin options
	if ( $post_id != '' ) {
		$count = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_comment_like_count", true ) : get_post_meta( $post_id, "_post_like_count", true ); // like count
		$count = ( isset( $count ) && is_numeric( $count ) ) ? $count : 0;
		if ( !already_liked( $post_id, $is_comment ) ) { // Like the post
			if ( is_user_logged_in() ) { // user is logged in
				$user_id = get_current_user_id();
				$post_users = post_user_likes( $user_id, $post_id, $is_comment );
				if ( $is_comment == 1 ) {
					// Update User & Comment
					$user_like_count = get_user_option( "_comment_like_count", $user_id );
					$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
					update_user_option( $user_id, "_comment_like_count", ++$user_like_count );
					if ( $post_users ) {
						update_comment_meta( $post_id, "_user_comment_liked", $post_users );
					}
				} else {
					// Update User & Post
					$user_like_count = get_user_option( "_user_like_count", $user_id );
					$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
					update_user_option( $user_id, "_user_like_count", ++$user_like_count );
					if ( $post_users ) {
						update_post_meta( $post_id, "_user_liked", $post_users );
					}
				}
			} else { // user is anonymous
				$user_ip = sl_get_ip();
				$post_users = post_ip_likes( $user_ip, $post_id, $is_comment );
				// Update Post
				if ( $post_users ) {
					if ( $is_comment == 1 ) {
						update_comment_meta( $post_id, "_user_comment_IP", $post_users );
					} else {
						update_post_meta( $post_id, "_user_IP", $post_users );
					}
				}
			}
			$like_count = ++$count;
			$response['status'] = "liked";
			$response['icon'] = get_liked_icon();
		} else { // Unlike the post
			if ( is_user_logged_in() ) { // user is logged in
				$user_id = get_current_user_id();
				$post_users = post_user_likes( $user_id, $post_id, $is_comment );
				// Update User
				if ( $is_comment == 1 ) {
					$user_like_count = get_user_option( "_comment_like_count", $user_id );
					$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
					if ( $user_like_count > 0 ) {
						update_user_option( $user_id, "_comment_like_count", --$user_like_count );
					}
				} else {
					$user_like_count = get_user_option( "_user_like_count", $user_id );
					$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
					if ( $user_like_count > 0 ) {
						update_user_option( $user_id, '_user_like_count', --$user_like_count );
					}
				}
				// Update Post
				if ( $post_users ) {
					$uid_key = array_search( $user_id, $post_users );
					unset( $post_users[$uid_key] );
					if ( $is_comment == 1 ) {
						update_comment_meta( $post_id, "_user_comment_liked", $post_users );
					} else {
						update_post_meta( $post_id, "_user_liked", $post_users );
					}
				}
			} else { // user is anonymous
				$user_ip = sl_get_ip();
				$post_users = post_ip_likes( $user_ip, $post_id, $is_comment );
				// Update Post
				if ( $post_users ) {
					$uip_key = array_search( $user_ip, $post_users );
					unset( $post_users[$uip_key] );
					if ( $is_comment == 1 ) {
						update_comment_meta( $post_id, "_user_comment_IP", $post_users );
					} else {
						update_post_meta( $post_id, "_user_IP", $post_users );
					}
				}
			}
			$like_count = ( $count > 0 ) ? --$count : 0; // Prevent negative number
			$response['status'] = "unliked";
			$response['icon'] = get_unliked_icon();
		}
		if ( $is_comment == 1 ) {
			update_comment_meta( $post_id, "_comment_like_count", $like_count );
			update_comment_meta( $post_id, "_comment_like_modified", date( 'Y-m-d H:i:s' ) );
		} else {
			update_post_meta( $post_id, "_post_like_count", $like_count );
			update_post_meta( $post_id, "_post_like_modified", date( 'Y-m-d H:i:s' ) );
		}
		$response['count'] = get_like_count( $like_count );
		$response['testing'] = $is_comment;
		if ( $disabled == true ) {
			if ( $is_comment == 1 ) {
				wp_redirect( get_permalink( get_the_ID() ) );
				exit();
			} else {
				wp_redirect( get_permalink( $post_id ) );
				exit();
			}
		} else {
			wp_send_json( $response );
		}
	}
}

/**
 * Utility to test if the post is already liked
 * @since    0.5
 */
function already_liked( $post_id, $is_comment ) {
	$post_users = NULL;
	$user_id = NULL;
	if ( is_user_logged_in() ) { // user is logged in
		$user_id = get_current_user_id();
		$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_liked" ) : get_post_meta( $post_id, "_user_liked" );
		if ( count( $post_meta_users ) != 0 ) {
			$post_users = $post_meta_users[0];
		}
	} else { // user is anonymous
		$user_id = sl_get_ip();
		$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_IP" ) : get_post_meta( $post_id, "_user_IP" );
		if ( count( $post_meta_users ) != 0 ) { // meta exists, set up values
			$post_users = $post_meta_users[0];
		}
	}
	if ( is_array( $post_users ) && in_array( $user_id, $post_users ) ) {
		return true;
	} else {
		return false;
	}
} // already_liked()

function get_simple_likes_button( $post_id, $is_comment = NULL ) {
	$is_comment = ( NULL == $is_comment ) ? 0 : 1;
	$output = '';
	$nonce = wp_create_nonce( 'simple-likes-nonce' ); // Security
	if ( $is_comment == 1 ) {
		$post_id_class = esc_attr( ' sl-comment-button-' . $post_id );
		$comment_class = esc_attr( ' sl-comment' );
		$like_count = get_comment_meta( $post_id, "_comment_like_count", true );
		$like_count = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
	} else {
		$post_id_class = esc_attr( ' sl-button-' . $post_id );
		$comment_class = esc_attr( '' );
		$like_count = get_post_meta( $post_id, "_post_like_count", true );
		$like_count = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
	}
	$count = get_like_count( $like_count );
	$icon_empty = get_unliked_icon();
	$icon_full = get_liked_icon();

	if ( already_liked( $post_id, $is_comment ) ) {
		$class = esc_attr( ' liked' );
		$title = __( 'Unlike', 'YourThemeTextDomain' );
		$icon = $icon_full;
	} else {
		$class = '';
		$title = __( 'Like', 'YourThemeTextDomain' );
		$icon = $icon_empty;
	}
	$output = '<span class="sl-wrapper"><a href="' . admin_url( 'admin-ajax.php?action=process_simple_like' . '&post_id=' . $post_id . '&nonce=' . $nonce . '&is_comment=' . $is_comment . '&disabled=true' ) . '" class="sl-button' . $post_id_class . $class . $comment_class . '" data-nonce="' . $nonce . '" data-post-id="' . $post_id . '" data-iscomment="' . $is_comment . '" title="' . $title . '">' . $icon . $count . '</a>' . $loader . '</span>';
	return $output;
} // get_simple_likes_button()

/**
 * Processes shortcode to manually add the button to posts
 * @since    0.5
 */
add_shortcode( 'jmliker', 'sl_shortcode' );
function sl_shortcode() {
	return get_simple_likes_button( get_the_ID(), 0 );
} // shortcode()

function post_user_likes( $user_id, $post_id, $is_comment ) {
	$post_users = '';
	$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_liked" ) : get_post_meta( $post_id, "_user_liked" );
	if ( count( $post_meta_users ) != 0 ) {
		$post_users = $post_meta_users[0];
	}
	if ( !is_array( $post_users ) ) {
		$post_users = array();
	}
	if ( !in_array( $user_id, $post_users ) ) {
		$post_users['user-' . $user_id] = $user_id;
	}
	return $post_users;
} // post_user_likes()

function post_ip_likes( $user_ip, $post_id, $is_comment ) {
	$post_users = '';
	$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_IP" ) : get_post_meta( $post_id, "_user_IP" );
	// Retrieve post information
	if ( count( $post_meta_users ) != 0 ) {
		$post_users = $post_meta_users[0];
	}
	if ( !is_array( $post_users ) ) {
		$post_users = array();
	}
	if ( !in_array( $user_ip, $post_users ) ) {
		$post_users['ip-' . $user_ip] = $user_ip;
	}
	return $post_users;
} // post_ip_likes()

function sl_get_ip() {
	if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) && ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = ( isset( $_SERVER['REMOTE_ADDR'] ) ) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
	}
	$ip = filter_var( $ip, FILTER_VALIDATE_IP );
	$ip = ( $ip === false ) ? '0.0.0.0' : $ip;
	return $ip;
} // sl_get_ip()

function get_liked_icon() {
	/* If already using Font Awesome with your theme, replace svg with: <i class="fa fa-heart"></i> */
	$icon = '<span class="sl-icon"><svg role="img" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" version="1.1" x="0" y="0" viewBox="0 0 128 128" enable-background="new 0 0 128 128" xml:space="preserve"><path id="heart-full" d="M124 20.4C111.5-7 73.7-4.8 64 19 54.3-4.9 16.5-7 4 20.4c-14.7 32.3 19.4 63 60 107.1C104.6 83.4 138.7 52.7 124 20.4z"/>&#9829;</svg></span>';
	return $icon;
} // get_liked_icon()

function get_unliked_icon() {
	/* If already using Font Awesome with your theme, replace svg with: <i class="fa fa-heart-o"></i> */
	$icon = '<span class="sl-icon"><svg role="img" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" version="1.1" x="0" y="0" viewBox="0 0 128 128" enable-background="new 0 0 128 128" xml:space="preserve"><path id="heart" d="M64 127.5C17.1 79.9 3.9 62.3 1 44.4c-3.5-22 12.2-43.9 36.7-43.9 10.5 0 20 4.2 26.4 11.2 6.3-7 15.9-11.2 26.4-11.2 24.3 0 40.2 21.8 36.7 43.9C124.2 62 111.9 78.9 64 127.5zM37.6 13.4c-9.9 0-18.2 5.2-22.3 13.8C5 49.5 28.4 72 64 109.2c35.7-37.3 59-59.8 48.6-82 -4.1-8.7-12.4-13.8-22.3-13.8 -15.9 0-22.7 13-26.4 19.2C60.6 26.8 54.4 13.4 37.6 13.4z"/>&#9829;</svg></span>';
	return $icon;
} // get_unliked_icon()

function sl_format_count( $number ) {
	$precision = 2;
	if ( $number >= 1000 && $number < 1000000 ) {
		$formatted = number_format( $number/1000, $precision ).'K';
	} else if ( $number >= 1000000 && $number < 1000000000 ) {
		$formatted = number_format( $number/1000000, $precision ).'M';
	} else if ( $number >= 1000000000 ) {
		$formatted = number_format( $number/1000000000, $precision ).'B';
	} else {
		$formatted = $number; // Number is less than 1000
	}
	$formatted = str_replace( '.00', '', $formatted );
	return $formatted;
} // sl_format_count()

function get_like_count( $like_count ) {
	$like_text = __( 'Like', 'YourThemeTextDomain' );
	if ( is_numeric( $like_count ) && $like_count > 0 ) {
		$number = sl_format_count( $like_count );
	} else {
		$number = $like_text;
	}
	$count = '<span class="sl-count">' . $number . '</span>';
	return $count;
} // get_like_count()

function wc_get_product_term_list( $product_id, $term, $sep = ', ', $before = '', $after = '' ) {
    return get_the_term_list( $product_id, $term, $before, $sep, $after );
}


add_action( 'init', 'artmo_set_user_display_name');

function artmo_set_user_display_name() {

    if (isset( $_GET['do_user_display_names'] )) {
    $args = array (
      'orderby' => 'registered',
      'order' => 'ASC'
    );
    $wp_user_query = new WP_User_Query( $args );
    $authors = $wp_user_query->get_results();

    if ( ! empty( $authors ) ) {
        foreach ( $authors as $author ) {
            $author_info = get_userdata( $author->ID );
            $firstName = $author_info->first_name;
            $lastName = $author_info->last_name;
            $nickName = $author_info->nickname;
            artmo_update_names($user_id, $firstName, $lastName, $userName, $nickName);
        }
    } else {
        echo 'No authors found';
    }
  }
}

add_action( 'um_registration_complete', 'myplugin_registration_save', 10, 2 );

function myplugin_registration_save( $user_id, $args ) {

	$ultimatemember = new UM();
	extract($args);

  $firstName = um_user('first_name');
  $lastName = um_user('last_name');
  $nickName = um_user('nickname');
  $userName = um_user('user_login');

  artmo_update_names($user_id, $firstName, $lastName, $userName, $nickName);

}

add_action('um_after_user_account_updated', 'um_change_names', 10, 1);
add_action( 'wcfm_profile_update', 'um_change_names', 10 );

function um_change_names( $user_id ) {

  $ultimatemember = new UM();
  um_fetch_user( $user_id );

  $firstName = um_user('first_name');
  $lastName = um_user('last_name');
  $nickName = um_user('nickname');
  $userName = um_user('user_login');

  $role = $ultimatemember->user()->get_role();

  if ( $role == 'um_artist' ) {
    $display_name_check = get_user_meta( $user_id, 'display_name_check', true );
    $user_display_name = get_user_meta( $user_id, 'user_display_name', true );

    if ((!empty($display_name_check)) && ($display_name_check == 'yes')) {
      update_user_meta($user_id, 'user_display_name', $user_display_name);
    } else {
      artmo_update_names($user_id, $firstName, $lastName, $userName, $nickName);
    }

  } else {
    artmo_update_names($user_id, $firstName, $lastName, $userName, $nickName);
  }
}

function artmo_update_names($user_id, $firstName, $lastName, $userName, $nickName) {
  if (( !empty( $firstName ) ) && ( !empty( $lastName ) )) {
      $full_name = $firstName . ' ' .  $lastName;
      update_user_meta($user_id, 'user_display_name', $full_name);
      artmo_update_vendor_categories($user_id, $full_name);
  } else if ( !empty( $firstName ) ) {
      update_user_meta($user_id, 'user_display_name', $firstName);
      artmo_update_vendor_categories($user_id, $firstName);
  } else if ( !empty( $userName ) ) {
      update_user_meta($user_id, 'user_display_name', $userName);
      artmo_update_vendor_categories($user_id, $userName);
  } else if ( !empty( $nickName ) ) {
      update_user_meta($user_id, 'user_display_name', $nickName);
      artmo_update_vendor_categories($user_id, $nickName);
  } else {
      update_user_meta($user_id, 'user_display_name', 'ARTMO User');
  }
}

function artmo_update_vendor_categories($user_id, $name) {

		$author_cat = 'artist_'.$user_id;
		$author_cat_obj = get_term_by('slug', $author_cat, 'artists_cat');
		$parent_id = $author_cat_obj->term_id;

    $term_exists = term_exists( $author_cat, 'artists_cat');

		// $term_exists = term_exists( $new_slug, 'artists_cat', intval($parent_id));

    if ( $term_exists !== 0 && $term_exists !== null ) {

    		$term_id = $term_exists['term_id'];
    		$cat_ids = array($term_id, $parent_id);
    		$cat_ids = array_map( 'intval', $cat_ids );
    		$cat_ids = array_unique( $cat_ids );

        $update = wp_update_term( $parent_id, 'artists_cat', array(
            'name' => $name
        ) );

        if ( ! is_wp_error( $update ) ) {
            echo 'Success!';
        }
    }
}

add_filter('um_profile_tabs', 'add_custom_profile_tab', 1000 );
function add_custom_profile_tab( $tabs ) {

	$tabs['mycustomtab'] = array(
		'name' => 'My custom tab',
		'icon' => 'um-faicon-cube',
	);

	return $tabs;

}

/* Then we just have to add content to that tab using this action */

add_action('um_profile_content_mycustomtab_default', 'um_profile_content_mycustomtab_default');
function um_profile_content_mycustomtab_default( $args ) {
	echo 'Hello world!';
}

function make_profiles_for_all_artists() {


  $args = array(

  	'include'      => array(707, 557, 568, 563, 567, 620, 570, 644, 651, 684, 671, 647, 722, 609, 640, 643, 559, 692, 654, 552, 569, 655 ),

   );
  $users = get_users( $args );

  foreach ($users as $user) {
    $user_id = $user->ID;
    $registered = get_user_meta($user_id, 'registered_vendor', true);

    if(empty($registered)) {

        $ultimatemember = new UM();

        um_fetch_user( $user_id );
        $role = artmo_get_user_roles_by_id( $user_id );
        $theRelevantRole = $role[0];
        $display_name = um_user('display_name');
        $user_login = um_user('user_login');


        if (empty(um_user('user_login'))) {
          $display_name = $user_id;
          $user_login = $user_id;
        }

        if ( $theRelevantRole == 'um_artist' ) {
          $term = wp_insert_term( $user_login, WC_PRODUCT_VENDORS_TAXONOMY );

            if ( ! is_wp_error( $term ) ) {
              $user = get_userdata( $user_id );
              WC_Product_Vendors_Utils::set_new_pending_vendor( $user_id );
              // add user to term meta
              $vendor_data = array();
              $vendor_data['admins']               = $user_id;
              $vendor_data['email']                = $user->user_email;
              $vendor_data['per_product_shipping'] = 'yes';
              $vendor_data['commission_type']      = 'percentage';

              update_term_meta( $term['term_id'], 'vendor_data', apply_filters( 'wcpv_registration_default_vendor_data', $vendor_data ) );

              wp_insert_term(
                $display_name,   // the term
                'artists_cat', // the taxonomy
                array(
                  'description' => '',
                  'slug'        => 'artist_'.$user_id
                )
              );

              // Getting the WP_User object
              $user->add_role( 'wc_product_vendors_manager_vendor' );

              add_user_meta($user_id, 'registered_vendor', 'true', true);

              ?>
            <?php
          } else {
            echo '<pre>'.var_dump($term->get_error_messages()).'</pre>';
          }
        }
      }
    }
}

//add_action('init', 'make_profiles_for_all_artists');

add_filter('wp_dropdown_users_args', 'assign_subscriber_author_func', 10, 2);
 function assign_subscriber_author_func($query_args, $r){
    $query_arg['who'] = 'um_artist';
    return $query_arg;
}


function nelio_max_image_size( $file ) {
  $size = $file['size'];
  $size = $size / 1024;
  $type = $file['type'];
  $is_image = strpos( $type, 'image' ) !== false;
  $limit = 5120;
  $limit_output = '5MB';
  if ( $is_image && $size > $limit ) {
    $file['error'] = 'Image files must be smaller than ' . $limit_output;
  }//end if
  return $file;
}//end nelio_max_image_size()
add_filter( 'wp_handle_upload_prefilter', 'nelio_max_image_size' );

function wt_handle_upload_callback( $data ) {
  $file_path = $data['file'];
  $image = false;
  $size = filesize($file_path);
  $sizeKb = $size / 1024;
  $units = $sizeKb / 300;
  $sqrt = sqrt($units);
  list($width, $height, $type, $attr) = getimagesize($data['file']);

  //if filesize < 307200
  //image quality is 60
  //make an image
  //else
  //image quality is factor * size such that if size = 10485760 then quality is 10.

  switch ( $data['type'] ) {
      case 'image/jpeg': {
          if ($sizeKb < 300) {
            $image_quality = 90;
            $image = imagecreatefromjpeg( $file_path );
            imagejpeg( $image, $file_path, $image_quality );
          } else {
            $image_quality = 90 - ($sqrt*3); // Change this according to your needs
            $image = imagecreatefromjpeg( $file_path );
            $imageResized = imagescale($image, intval($width / $sqrt));
            imagejpeg( $imageResized, $file_path, intval($image_quality) );
          }
          break;
      }

      case 'image/png': {
        if ($sizeKb < 300) {
          $image_quality = 9;
          $image = imagecreatefrompng( $file_path );
          imagepng( $image, $file_path, $image_quality );
        } else {
          $image_quality = (90 - ($sqrt*6)) / 10; // Change this according to your needs
          $image = imagecreatefrompng( $file_path );
          $imageResized = imagescale($image, intval($width / $sqrt));
          imagepng( $imageResized, $file_path, intval($image_quality) );
        }
          break;
      }

      case 'image/gif': {
          // Nothing to do here since imagegif doesn't have an 'image quality' option
          break;
      }
  }

    return $data;
}
add_filter( 'wp_handle_upload', 'wt_handle_upload_callback' );


/**
 * Duplicate a post/page/custom post on publish or update
 *
 **/


add_action( 'woocommerce_product_query', 'custom_pre_get_posts_query' );
function custom_pre_get_posts_query( $query ) {

    $query->set( 'meta_query', array( array(
       'key' => '_thumbnail_id',
       'value' => '0',
       'compare' => '>'
    )));

}

add_action( 'restrict_manage_posts', 'wpse45436_admin_posts_filter_restrict_manage_posts' );
/**
 * First create the dropdown
 * make sure to change POST_TYPE to the name of your custom post type
 *
 * @author Ohad Raz
 *
 * @return void
 */
function wpse45436_admin_posts_filter_restrict_manage_posts(){
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }

    //only add filter to post type you want
    if ('product' == $type){
        //change this to the list of values you want to show
        //in 'label' => 'value' format
        $values = array(
            'label' => 'value',
            'label1' => 'value1',
            'label2' => 'value2',
        );
        ?>
        <select name="ADMIN_FILTER_FIELD_VALUE">
        <option value=""><?php _e('Filter By ', 'wose45436'); ?></option>
        <?php
            $current_v = isset($_GET['ADMIN_FILTER_FIELD_VALUE'])? $_GET['ADMIN_FILTER_FIELD_VALUE']:'';
            foreach ($values as $label => $value) {
                printf
                    (
                        '<option value="%s"%s>%s</option>',
                        $value,
                        $value == $current_v? ' selected="selected"':'',
                        $label
                    );
                }
        ?>
        </select>
        <?php
    }
}


add_filter( 'parse_query', 'wpse45436_posts_filter' );

function wpse45436_posts_filter( $query ){
    global $pagenow;
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    if ( 'POST_TYPE' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['ADMIN_FILTER_FIELD_VALUE']) && $_GET['ADMIN_FILTER_FIELD_VALUE'] != '') {
        $query->query_vars['meta_key'] = 'META_KEY';
        $query->query_vars['meta_value'] = $_GET['ADMIN_FILTER_FIELD_VALUE'];
    }
}

function rudr_posts_taxonomy_filter() {
	global $typenow; // this variable stores the current custom post type
	if( $typenow == 'product' ){ // choose one or more post types to apply taxonomy filter for them if( in_array( $typenow  array('post','games') )
		$taxonomy_names = array('artists_cat');
		foreach ($taxonomy_names as $single_taxonomy) {
			$current_taxonomy = isset( $_GET[$single_taxonomy] ) ? $_GET[$single_taxonomy] : '';
			$taxonomy_object = get_taxonomy( $single_taxonomy );
			$taxonomy_name = strtolower( $taxonomy_object->labels->name );
			$taxonomy_terms = get_terms( array( 'taxonomy' => $single_taxonomy, 'parent' => 0 ));
			if(count($taxonomy_terms) > 0) {
				echo "<select name='$single_taxonomy' id='$single_taxonomy' class='postform'>";
				echo "<option value=''>All $taxonomy_name</option>";
				foreach ($taxonomy_terms as $single_term) {
					echo '<option value='. $single_term->slug, $current_taxonomy == $single_term->slug ? ' selected="selected"' : '','>' . $single_term->name .' (' . $single_term->count .')</option>';
				}
				echo "</select>";
			}
		}
	}
}

add_action( 'restrict_manage_posts', 'rudr_posts_taxonomy_filter' );

add_action( 'wp_ajax_nopriv_ajax_pagination', 'my_ajax_pagination' );
add_action( 'wp_ajax_ajax_pagination', 'my_ajax_pagination' );


function my_ajax_pagination() {

    $output = '';

    $query_vars = json_decode( stripslashes( $_POST['query_vars'] ), true );

    $query_vars['paged'] = $_POST['page'];


    $args=array('post_type'=>'product','order'=>'desc','posts_per_page'=>-1);

    $posts = new WP_Query( $args );
    $GLOBALS['wp_query'] = $posts;

    add_filter( 'editor_max_image_size', 'my_image_size_override' );

    if( ! $posts->have_posts() ) {
        $output .= get_template_part( 'content', 'none' );
    }
    else {
        while ( $posts->have_posts() ) {
            $posts->the_post();
            wc_get_template_part( 'content', 'product' );
        }
    }
    remove_filter( 'editor_max_image_size', 'my_image_size_override' );

    the_posts_pagination( array(
        'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
        'next_text'          => __( 'Next page', 'twentyfifteen' ),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
    ) );

    return $output;

    die();
}

function my_image_size_override() {
    return array( 825, 510 );
}

if( get_role('subscriber') ){
      remove_role( 'subscriber' );
}

add_action('init', 'woocommerce_price_filter_init');
add_filter('loop_shop_post_in', 'woocommerce_price_filter');

function woocommerce_price_filter_init() {

	unset($_SESSION['min_price']);
	unset($_SESSION['max_price']);

	if (isset($_GET['min_price'])) :
		$_SESSION['min_price'] = $_GET['min_price'];
	endif;
	if (isset($_GET['max_price'])) :
		$_SESSION['max_price'] = $_GET['max_price'];
	endif;

}

/**
 * Price Filter post filter
 */
function woocommerce_price_filter( $filtered_posts ) {

	if (isset($_GET['max_price']) && isset($_GET['min_price'])) :

		$matched_products = array();

		$matched_products_query = get_posts(array(
			'post_type' => array(
				'product_variation',
				'product'
			),
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => '_price',
					'value' => array( $_GET['min_price'], $_GET['max_price'] ),
					'type' => 'NUMERIC',
					'compare' => 'BETWEEN'
				)
			)
		));

		if ($matched_products_query) :
			foreach ($matched_products_query as $product) :
				if ($product->post_type == 'product') $matched_products[] = $product->ID;
				if ($product->post_parent>0 && !in_array($product->post_parent, $matched_products))
					$matched_products[] = $product->post_parent;
			endforeach;
		endif;

		// Filter the id's
		if (sizeof($filtered_posts)==0) :
			$filtered_posts = $matched_products;
			$filtered_posts[] = 0;
		else :
			$filtered_posts = array_intersect($filtered_posts, $matched_products);
			$filtered_posts[] = 0;
		endif;

	endif;

	return (array) $filtered_posts;
}

add_filter('woocommerce_empty_price_html', 'custom_call_for_price');

function custom_call_for_price() {
     return 'Price on request';
}

session_start();
add_filter( 'posts_orderby', 'randomise_with_pagination' );
function randomise_with_pagination( $orderby ) {
  $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
  if ( 'random_list' == $orderby_value ) {
      if( is_shop() ) {
    	  	// Reset seed on load of initial archive page
    		if( ! get_query_var( 'paged' ) || get_query_var( 'paged' ) == 0 || get_query_var( 'paged' ) == 1 ) {
    			if( isset( $_SESSION['seed'] ) ) {
    				unset( $_SESSION['seed'] );
    			}
    		}

    		// Get seed from session variable if it exists
    		$seed = false;
    		if( isset( $_SESSION['seed'] ) ) {
    			$seed = $_SESSION['seed'];
    		}

    	    	// Set new seed if none exists
    	    	if ( ! $seed ) {
    	      		$seed = rand();
    	      		$_SESSION['seed'] = $seed;
    	    	}

    	    	// Update ORDER BY clause to use seed
    	    	$orderby = 'RAND(' . $seed . ')';
    	}
    }
	return $orderby;
}


add_filter( 'woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args' );

function custom_woocommerce_get_catalog_ordering_args( $args ) {
    $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

    if ( 'random_list' == $orderby_value ) {
        $args['orderby'] = '';
        $args['order'] = '';
        $args['meta_key'] = '';
    }
    return $args;
}

add_filter( 'woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby' );

function custom_woocommerce_catalog_orderby( $sortby ) {
    $sortby['random_list'] = 'Random';
    return $sortby;
}

add_action( 'transition_post_status', 'product_approved_notification', 10, 3);

function product_approved_notification(  $new_status, $old_status, $post  ) {
  if ( ! WC_Product_Vendors_Utils::auth_vendor_user() || 'product' !== get_post_type( $post->ID ) ) {
    return;
  }
  if ( 'publish' === $new_status && $old_status !== $new_status ) {
    $emails = WC()->mailer()->get_emails();
    if ( ! empty( $emails ) ) {
      $emails[ 'WC_Product_Vendors_Product_Approved_Notice' ]->trigger( $post );
    }
  }
  return true;
}

add_filter('um_profile_tabs', 'my_collection_tab', 2000 );
function my_collection_tab( $tabs ) {



	$user_id = um_get_requested_user();
  um_fetch_user( $user_id );
  $role = artmo_get_user_roles_by_id( $user_id );
  $theRelevantRole = $role[0];
  $registered = get_user_meta($user_id, 'registered_vendor', true);

  if ( $theRelevantRole === 'um_artist' ) {
  	// Show to profile owners only
  	if ( is_user_logged_in() && get_current_user_id() == $user_id ) {
      if(!empty($registered)) {
  		$tabs['my_collection'] = array(
  			'name' => 'Dashboard',
  			'icon' => 'fa fa-dashboard',
  			'custom' => true
  		);
    } else {
      $tabs['my_collection'] = array(
        'name' => 'Vendor Signup',
        'icon' => 'fa fa-dashboard',
        'custom' => true
      );
    }
  	}
  }
  return $tabs;
}

add_filter('um_profile_content_my_collection', 'my_collection_tab_content' );
function my_collection_tab_content($args) {



  $user_id = get_current_user_id();
  um_fetch_user($user_id);

  wp_redirect(um_user_profile_url() . '/?collection_link');
  exit;

}


add_filter('um_profile_tabs', 'art_collection_tab', 2000 );
function art_collection_tab( $tabs ) {

	$user_id = um_get_requested_user();
  um_fetch_user( $user_id );
  $role = artmo_get_user_roles_by_id( $user_id );
  $theRelevantRole = $role[0];

  if ( $theRelevantRole === 'um_artist' ) {

  $args = array(
      'post_type'  => 'product',
      'author'     => $user_id,
  );

  $wp_posts = get_posts($args);

  if (get_current_user_id() !== $user_id && count($wp_posts)) {
    $tabs['art_collection'] = array(
      'name' => "Collection",
      'icon' => 'fa fa-star',
      'custom' => true
    );
  }
}

  return $tabs;
}

//
// function get_genre_tags() {
//
// }


add_filter('um_profile_content_art_collection', 'art_collection_tab_content' );
function art_collection_tab_content($args) {

  $user_id = um_get_requested_user();
  //um_fetch_user($user_id);

  wp_redirect(get_permalink( woocommerce_get_page_id( 'shop' ) ) . '/?swoof=1&artists_cat=artist_' . $user_id);
  exit;
}

function retrieve_genre_tags_artist() {

  $user_id = um_get_requested_user();
  um_fetch_user( $user_id );
  $role = artmo_get_user_roles_by_id( $user_id );
  $theRelevantRole = $role[0];

  if ( $theRelevantRole === 'um_artist' ) {
    $args = array(
        'post_type'  => 'product',
        'author'     => $user_id,
    );
    $wp_posts = get_posts($args);
    $tags = array();
    $medium_cats = array();
    $contents = '';

    if (count($wp_posts)) {
        foreach ( $wp_posts as $post ) :
          $post_id = $post->ID;
          $terms = wp_get_post_terms($post_id, 'genre_tag');
          $media = wp_get_post_terms($post_id, 'medium_cat');
          foreach ($terms as $cat) {
             array_push($tags, $cat->name);
          }
          foreach ($media as $cat) {
             array_push($medium_cats, $cat->name);
          }

        endforeach;

        $tags = array_unique($tags);
        $medium_cats = array_unique($medium_cats);

      //return the tags
      $contents .= '<div class="um-profile-genres">';
      $contents .= '<div class="genres-title um-profile um-viewing um-field-label"><label>' . __('GENRES:', 'vantage-child') . '</label></div>';
      $contents .= '<div class="um-profile-tags">';
      foreach ($tags as $tag) {
        $contents .= '<span class="um-profile-genre-tag"><a href="'. get_home_url() . '/?swoof=1&genre_tag=' . sanitize_title($tag) .'">'.$tag.'</a></span>';
      }
      foreach ($medium_cats as $cat) {
        $contents .= '<span class="um-profile-genre-tag"><a href="'. get_home_url() . '/?swoof=1&medium_cat=' . sanitize_title($cat) .'">'.$cat.'</a></span>';
      }
      $contents .= '</div>';
      $contents .= '</div>';
      return $contents;
    }
    return false;
  }
}

add_shortcode('retrieve_genre_tags_artist', 'retrieve_genre_tags_artist');

function retrieve_series_artist() {

  $user_id = um_get_requested_user();
  um_fetch_user( $user_id );
  $role = artmo_get_user_roles_by_id( $user_id );
  $theRelevantRole = $role[0];

  if ( $theRelevantRole === 'um_artist' ) {

      $args = array(
          'post_type'  => 'product',
          'author'     => $user_id,
          'post_status'=> 'publish',
          'posts_per_page' => -1,
      );
      $wp_posts = get_posts($args);

      $contents = '';
      $series = array();

      if (count($wp_posts)) {
          foreach ( $wp_posts as $post ) :
            $post_id = $post->ID;

            $artist_cat_parent = get_term_by('slug', 'artist_' . $user_id, 'artists_cat');
            $artist_cat_id = $artist_cat_parent->term_id;

            $terms = wp_get_post_terms($post_id, 'artists_cat');

            foreach ($terms as $cat) {
              $cat_id = (int)$cat->term_id;
              if (cat_is_ancestor_of($artist_cat_parent, $cat)) {
               array_push($series, $cat->name);
              }
            }

          endforeach;

        $series = array_unique($series);

        if (!empty($series)) {
          $contents .= '<div class="um-profile-genres">';
          $contents .= '<div class="genres-title um-profile um-viewing um-field-label"><label>' . __('SERIES:', 'vantage-child') . '</label></div>';
          $contents .= '<div class="um-profile-tags">';
          foreach ($series as $tag) {
            $contents .= '<span class="um-profile-genre-tag"><a href="'. get_home_url() . '/?swoof=1&artists_cat=' . sanitize_title($tag) .'">'.$tag.'</a></span>';
          }
          $contents .= '</div>';
          $contents .= '</div>';
          return $contents;
        }
      }
    }
    return false;
  }


add_shortcode('retrieve_series_artist', 'retrieve_series_artist');

add_action( 'added_post_meta', 'mp_sync_on_product_save', 10, 4 );
add_action( 'updated_post_meta', 'mp_sync_on_product_save', 10, 4 );

function mp_sync_on_product_save( $meta_id, $post_id, $meta_key, $meta_value ) {
    if ( $meta_key == '_thumbnail_id' ) { // we've been editing the post thumbnail
        if ( get_post_type( $post_id ) == 'product' ) { // we've been editing a product
            $product = wc_get_product( $post_id );
            // do something with this product
            $image_id = $product->get_image_id();
            $image_url = wp_get_attachment_url( $image_id );
  					$clarifai_url = 'https://api.clarifai.com/v2/models/eeed0b6733a644cea07cf4c60f87ebb7/outputs';
  					$clarifai_api_key = 'ffc3390c9aed4952b0f0900b9d223aea';

  					$response = wp_remote_post( $clarifai_url, array(
  						'method' => 'POST',
  						'timeout' => 45,
  						'blocking' => true,
  						'headers' => array( 'Authorization' => 'Key '.$clarifai_api_key, 'Content-Type' => 'application/json' ),
  						'body' => json_encode(
  							array (
  							  'inputs' =>
  							  array (
  							    0 =>
  							    array (
  							      'data' =>
  							      array (
  							        'image' =>
  							        array (
  							          'url' => $image_url,
  							        )
  							      )
  							    )
  							  )
  							)
  						)
  					)
  			  );

					if ( is_wp_error( $response ) ) {
					    $error_message = $response->get_error_message();
							update_post_meta($new_product_id, 'colors', $error_message);
					} else {
							$response_data = wp_remote_retrieve_body($response);
              $response_data_arr = json_decode($response_data, true);
					   	$colors = $response_data_arr['outputs'][0]['data']['colors'];
						 	if(!empty($colors)){
								$first = true;
								foreach( $colors as $color ) {
									$color_name = $color['w3c']['name'];
									if ( $first ) {
										wp_set_object_terms( $post_id, $color_name, 'color_tag' );
										update_post_meta($post_id, 'colors', $color_name);
										$first = false;
									} else {
										wp_set_object_terms( $post_id, $color_name, 'color_tag', true );
										update_post_meta($post_id, 'colors', $color_name);
									}
								}

                update_post_meta($post_id, 'colors', $colors);
							} else {
                update_post_meta($post_id, 'colors', $response_data);
              }
						}
        }
    }
}

function add_messaging_button_um() {
  global $woocommerce, $post, $product;
  $product_id = $post->ID;
  $authordata = get_userdata($post->post_author);
  $author = $authordata->ID;
  echo do_shortcode('[ultimatemember_message_button user_id="' . $author . '"]');
}

add_action( 'woocommerce_after_add_to_cart_button', 'add_messaging_button_um');

function artmo_send_private_message($to, $from, $message){
  //We do not want to message ourselves
  if ($from==$to) return;
  // Create conversation and add message
  $_POST['content']  = $message;
  $conversation_id = UM()->Messaging_API()->api()->create_conversation( $to, $from );;
  $_POST['content'] = "";
  do_action('um_after_new_message', $to, $from, $conversation_id );
}

// Registering custom post status
function wpb_custom_post_status(){
    register_post_status('rejected', array(
        'label'                     => _x( 'Rejected', 'product' ),
        'public'                    => false,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Rejected <span class="count">(%s)</span>', 'Rejected <span class="count">(%s)</span>' ),
    ) );
}
add_action( 'init', 'wpb_custom_post_status' );
// Using jQuery to add it to post status dropdown
add_action('admin_footer-post.php', 'wpb_append_post_status_list');
function wpb_append_post_status_list(){
global $post;
$complete = '';
$label = '';
if($post->post_type == 'product'){
if($post->post_status == 'rejected'){
$complete = ' selected="selected"';
$label = '<span id="post-status-display"> Rejected</span>';
}
echo '
<script>
jQuery(document).ready(function($){
$("select#post_status").append("<option value=\"rejected\" '.$complete.'>Rejected</option>");
$(".misc-pub-section label").append("'.$label.'");
});
</script>
';
}
}

function artmo_get_membership_user_roles () {
  return array('um_artist', 'wc_product_vendors_admin_vendor', 'wcfm_vendor');
}

add_filter('wcfm_allowed_membership_user_roles', 'artmo_get_membership_user_roles');

// add_filter('wcfm_membership_registration_fields', array() );

function randomGen($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}

function artmo_profiles_carousel() {

      // WP_User_Query arguments
      $args = array (
          'role__in'    => array('um_artist', 'um_member', 'um_university', 'um_gallery'),
          'number' => '20',
          'orderby' => 'followers',
          'order' => 'DESC',
          'meta_query' => array(
            'relation' => 'AND',
            array(
              'key' => 'cover_photo',
              'value' => '',
              'compare' => '!='
            ),
            array(
              'key' => 'profile_photo',
              'value' => '',
              'compare' => '!='
            ),
            array(
              'key' => 'countryField',
              'value' => '',
              'compare' => '!='
            ),
            array(
              'key' => 'cityField',
              'value' => '',
              'compare' => '!='
            ),
          )
      );

      // Create the WP_User_Query object
      $wp_user_query = new WP_User_Query($args);

      // Get the results
      $mostFollowed = $wp_user_query->get_results();

      // WP_User_Query arguments
      $args2 = array (
          'role__in'    => array('um_artist', 'um_member', 'um_university', 'um_gallery'),
          'number' => '40',
          'orderby' => 'ID',
          'order' => 'DESC',
          'meta_query' => array(
            'relation' => 'AND',
            array(
              'key' => 'cover_photo',
              'value' => '',
              'compare' => '!='
            ),
            array(
              'key' => 'profile_photo',
              'value' => '',
              'compare' => '!='
            ),
            array(
              'key' => 'countryField',
              'value' => '',
              'compare' => '!='
            ),
            array(
              'key' => 'cityField',
              'value' => '',
              'compare' => '!='
            ),
          )
      );

      // Create the WP_User_Query object
      $wp_user_query2 = new WP_User_Query($args2);

      // Get the results
      $mostRecent = $wp_user_query2->get_results();

      $followedCount = 18;
      $recentCount = 36;
      //$totalUsers = ($followedCount + $recentCount) / 2;

      $followedSelected = randomGen(1,$followedCount,$followedCount/2);
      $recentSelected = randomGen(1,$recentCount,$recentCount/2);

      $allUsers = array();

      // for ($i=0; $i<$totalUsers; $i++) {
      //    $allUsers[] = $mostFollowed[$i];
      //    $allUsers[] = $mostRecent[$i];
      // }

      for ($i=0; $i<($followedCount/2); $i++) {
         $allUsers[] = $mostFollowed[$followedSelected[$i]];
      }

      for ($i=0; $i<($recentCount/2); $i++) {
         $allUsers[] = $mostRecent[$recentSelected[$i]];
      }

      shuffle($allUsers);


      global $wp_roles;

            // Check for results
            if (!empty($allUsers)) {
              $ultimatemember = new UM(); ?>



              <div class="members-slider">
                <h1 class="members-slider-header"><?php _e('CONNECTING THE ART WORLD', 'vantage-child'); ?></h1>
              <div class="members-slider-container">

              <?php
              // loop through each user
              foreach ($allUsers as $user)
              {

                $user_id = $user->ID;
                $i++; um_fetch_user( $user_id );
                $role_slug = um_user('role');
                $role = $wp_roles->roles[$role_slug]['name'];
                $artistCountry = get_user_meta($user_id, 'countryField', true);
                $artistCity = get_user_meta($user_id, 'cityField', true);

                if (!empty($artistCountry) && !empty($artistCity)) {
                  $location = '<span class="artist-country">' . $artistCountry . '</span><span class="artist-city"> | ' . $artistCity . '</span>';
                } else {
                  $location = $artistCity . $artistCountry;
                }

                ?>

                <div class="um-member um-member-slider um-role-<?php echo um_user('role'); ?> <?php echo um_user('account_status'); ?>">

                  <span class="um-member-status <?php echo um_user('account_status'); ?>"><?php echo um_user('account_status_name'); ?></span>

                  <?php
                    $sizes = um_get_option('cover_thumb_sizes');
                  ?>

                  <div class="um-member-cover" data-ratio="<?php echo um_get_option('profile_cover_ratio'); ?>">
                    <div class="um-member-cover-e"><a href="<?php echo um_user_profile_url(); ?>" title="<?php echo esc_attr(um_user('display_name')); ?>"><?php echo um_user('cover_photo', $sizes[0]); ?></a></div>
                  </div>
                  <?php
                    $default_size = str_replace( 'px', '', um_get_option('profile_photosize') );
                    $corner = um_get_option('profile_photocorner');
                  ?>
                  <div class="um-member-photo radius"><a href="<?php echo um_user_profile_url(); ?>" title="<?php echo esc_attr(um_user('display_name')); ?>"><?php echo get_avatar( um_user('ID'), $default_size ); ?></a></div>
                    <div class="um-member-card">
                      <div class="um-member-name"><a href="<?php echo um_user_profile_url(); ?>" title="<?php echo esc_attr(um_user('display_name')); ?>"><?php echo um_user('display_name', 'html'); ?></a></div>
                        <div class="um-member-meta">
                          <p><?php echo $role; ?></p>
                          <p><?php echo $location; ?></p>
                        </div>
                        <div class="um-member-follow">
                          <?php echo UM()->Followers_API()->api()->follow_button( $user_id, get_current_user_id() ); ?>
                        </div>
                    </div>
                </div>
                <?php

                //echo $user_id;
                 um_reset_user_clean();
               } ?>
                </div>
                <div class="members-slider-nav">
                  <div class="slider-nav-bck"><i class="ion ion-chevron-left"></i></div>
                  <div class="slider-nav-fwd"><i class="ion ion-chevron-right"></i></div>
                </div>
                </div>

                <?php
                um_reset_user();
            } else {
                echo 'No users found';
            }

}


add_shortcode('artmo_profiles_carousel', 'artmo_profiles_carousel');

add_filter('woocs_raw_woocommerce_price', 'artmo_round_price');
add_filter('woocs_exchange_value', 'artmo_round_price');


function artmo_round_price($price) {

  $floored = floor($price);
  $diff = $price - $floored;

  if ($diff <= 0.15) {
    return $floored;
  } else if ($diff > 0.15 && $diff <= 0.65) {
    return round($price * 2, 0) / 2;
  } else {
    return round($price);
  }
}


add_filter( 'wc_price', 'my_price', 3, 60 );

function my_price( $return, $price, $args ) {

  $price = (string)$price;

  $currency = get_woocommerce_currency();

  $decimalCommaCurr = array( 'USD', 'GBP', 'CNY', 'JPY' );

  if (in_array($currency, $decimalCommaCurr)) {
    $decimal_separator = '.';
    $thousand_separator = ',';
  } else {
    $decimal_separator = wc_get_price_decimal_separator();
    $thousand_separator = wc_get_price_thousand_separator();
  }

   //$price = number_format( $price, wc_get_price_decimals(), wc_get_price_decimal_separator(), wc_get_price_thousand_separator() );

   $decimals = wc_get_price_decimals();

   if ($decimals > 0) {
     $priceArr = explode(wc_get_price_decimal_separator(), $price);
     $fullPriceStr = number_format(intval(str_replace(wc_get_price_thousand_separator(), '', $priceArr[0])), 0, $decimal_separator, $thousand_separator);
     $priceTagged = '<span class="price-full-numbers">' .  $fullPriceStr . '</span><span class="price-decimals">' . $decimal_separator . $priceArr[1] . '</span>';
   } else {
     $fullPriceStr = number_format(intval(str_replace(wc_get_price_thousand_separator(), '', $price)), 0, $decimal_separator, $thousand_separator);
     $priceTagged = $fullPriceStr;
   }


   $formatted_price = '<span class="woocommerce-Price-currencySymbol">' . get_woocommerce_currency_symbol( ) . '</span>' . '<span class="woocommerce-Price-number">' . $priceTagged . '</span>' ;
   $returnVal = '<span class="woocommerce-Price-amount amount">' . $formatted_price . '</span>';

	return $returnVal;
}



function artmo_subscription_price( $price ) {

  $price = number_format($price, 2);

  $price = (string)$price;

  $currency = get_woocommerce_currency();

  $decimalCommaCurr = array( 'USD', 'GBP', 'CNY', 'JPY' );

  if (in_array($currency, $decimalCommaCurr)) {
    $decimal_separator = '.';
    $thousand_separator = ',';
  } else {
    $decimal_separator = wc_get_price_decimal_separator();
    $thousand_separator = wc_get_price_thousand_separator();
  }

   //$price = number_format( $price, wc_get_price_decimals(), wc_get_price_decimal_separator(), wc_get_price_thousand_separator() );

   $decimals = wc_get_price_decimals();

   if ($decimals > 0) {
     $priceArr = explode('.', $price);
     $fullPriceStr = number_format(intval(str_replace(',', '', $priceArr[0])), 0, $decimal_separator, $thousand_separator);
     $priceTagged = '<span class="price-full-numbers">' .  $fullPriceStr . '</span><span class="price-decimals">' . $decimal_separator . $priceArr[1] . '</span>';
   } else {
     $fullPriceStr = number_format(intval(str_replace(',', '', $price)), 0, $decimal_separator, $thousand_separator);
     $priceTagged = $fullPriceStr;
   }


   $formatted_price = '<span class="woocommerce-Price-currencySymbol">' . get_woocommerce_currency_symbol( ) . '</span>' . '<span class="woocommerce-Price-number">' . $priceTagged . '</span>' ;
   $returnVal = '<span class="woocommerce-Price-amount amount">' . $formatted_price . '</span>';

	return $returnVal;
}

function artmo_hello_world() {
  echo 'hello world';
}

add_shortcode('artmo_hello_world', 'artmo_hello_world');
