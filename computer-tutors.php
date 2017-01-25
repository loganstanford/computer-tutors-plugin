<?php
/*
Plugin Name: Computer Tutors
Plugin URI: https://ctusa1.com
Description: Computer Tutors plugin is one of the worlds largest, most advanced WordPress Plugin ever to be developed by the human species. Damn those Traflamadors
Version: 0.1
Author: Logan Stanford
Author URI:
License: GPLv2 or later
Text Domain: logan
*/

require plugin_dir_path(__FILE__) . 'inc/functions-single.php';

/*
  =============================================
  Includes style.css from this directory for use
  =============================================
*/
function ct_plugin_style() {
  $ct_handle = 'ct-styles';

  $ct_style_path = plugin_dir_url(__FILE__);

  wp_enqueue_style($ct_handle, $ct_style_path.'style.css');

}

add_action('wp_enqueue_scripts', 'ct_plugin_style');
add_action('admin_enqueue_scripts', 'ct_plugin_style');


/*
  =============================================
  Classes Custom Post Type
  =============================================
*/

function ct_class_post_type() {
  $labels = array(
    'name' => 'Classes',
    'singular_name' => 'Class',
    'add_new' => 'Add Class',
    'all_items' => 'All Classes',
    'add_new_item' => 'Add Class',
    'edit_item' => 'Edit Class',
    'update_item' => 'Update Class',
    'new_item' => 'New Class',
    'view_item' => 'View Class',
    'search_item' => 'Search Classes',
    'not_found' => 'No Classes found',
    'not_found_in_trash' => 'No Classes found in the trash',
    'parent_item_colon' => 'Parent Class'
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'has_archive' => true,
    'publicly_queryable' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => true,
    'supports' => array(
      'title',
      'excerpt',
      'thumbnail',
      'revisions',
      'page-attributes'
    ),
    'menu_position' => 5,
    'menu_icon' => 'dashicons-welcome-learn-more',
    'exclude_from_search' => false,
  );
  register_post_type('class',$args);
}
add_action('init','ct_class_post_type');

/*
  ========================================
    Creates custom taxonomies
  ========================================
*/
      // Topics
function ct_classes_taxonomies() {
  $labels = array(
    'name' => 'Topics',
    'singular_name' => 'Topic',
    'search_items' => 'Search Topics',
    'all_items' => 'All Topics',
    'parent_item' => 'Parent Topic',
    'parent_item_colon' => 'Parent Topic:',
    'edit_item' => 'Edit Topic',
    'update_item' => 'Update Topic',
    'add_new_item' => 'Add New Topic',
    'new_item_name' => 'New Topic Name',
    'not_found' => 'No Topics Found',
    'menu_name' => 'Topics'
  );

  $args = array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array(
      'slug' => 'topics',
      'hierarchical' => true,
   ),
  );

  register_taxonomy('topic', 'class', $args);

      // Fields
    $labels = array(
    'name' => 'Fields',
    'singular_name' => 'Field',
    'search_items' => 'Search Fields',
    'all_items' => 'All Fields',
    'parent_item' => 'Parent Field',
    'parent_item_colon' => 'Parent Field:',
    'edit_item' => 'Edit Field',
    'update_item' => 'Update Field',
    'add_new_item' => 'Add New Field',
    'new_item_name' => 'New Field Name',
    'not_found' => 'No fields found',
    'menu_name' => 'Fields'
  );

  $args = array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array(
      'slug' => 'field',
      'hierarchical' => true,
    ),
  );

  register_taxonomy('field', 'class', $args);

      // Certification Tracks
  $labels = array(
    'name' => 'Certification Tracks',
    'singular_name' => 'Certification Track',
    'search_items' => 'Search Certification Tracks',
    'all_items' => 'All Certification Tracks',
    'parent_item' => 'Parent Certification Track',
    'parent_item_colon' => 'Parent Certification Track:',
    'edit_item' => 'Edit Certification Track',
    'update_item' => 'Update Certification Track',
    'add_new_item' => 'Add New Certification Track',
    'new_item_name' => 'New Certification Track Name',
    'not_found' => 'No certification tracks found',
    'menu_name' => 'Certification Tracks'
  );

  $args = array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'certification' ),
  );

  register_taxonomy('certification', 'class', $args);

}

add_action( 'init', 'ct_classes_taxonomies');

/*
  ========================================
    Creates classes meta boxes (deprecated for use of custom meta boxes plugin code below)
  ========================================
*/
// function ct_add_class_metaboxes() {
//   add_meta_box('ct_price_mb', 'Price', 'ct_price_meta', 'class', 'side', 'default');
//   add_meta_box('ct_agenda_mb', 'Agenda', 'ct_agenda_meta', 'class', 'normal', 'default');
//   add_meta_box('ct_details_mb', 'Class Details', 'ct_details_meta', 'class', 'normal', 'high');
// }
// add_action( 'add_meta_boxes', 'ct_add_class_metaboxes' );
//
//
// // Generates the code for inside the metabox
// function ct_price_meta() {
//   global $post;
//   if (get_post_type($post) == 'class') {
//     echo '<input type="hidden" name="classmeta_noncename" id="classmeta_noncename" value="'.
//     wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
//
//     $price = get_post_meta($post->ID, '_price', true);
//
//     echo '<span style="font-size:16px;"><strong>$</strong>&nbsp;<input type="text" name="_price" value="' . $price . '" class="" />';
//     }
//   }
//
//   // Generates the code for inside the agenda metabox
//   function ct_agenda_meta() {
//       wp_nonce_field( basename( __FILE__ ), 'details_meta_box_nonce' );
//       $agenda = get_post_meta($post->ID, '_agenda', true);
//
//   }
//
//   // Generates the code for the inside the agenda metabox
//   function ct_details_meta() {
//       wp_nonce_field( basename( __FILE__ ), 'details_meta_box_nonce' );
//   }


/*
  ============================================================
    Creates meta boxes using code from the Meta Box plugin
  ============================================================
*/
  function ct_meta_boxes( $meta_boxes ) {

    $prefix = 'ct_';

    // Class details meta box for the event post type
      $meta_boxes[] = array(
        'title'      => __( 'Class Details', 'textdomain' ),
        'post_types' => 'class',
        'fields'     => array(
          array(
            'id'   => $prefix . 'standalone',
            'name' => __( 'Standalone class?', 'textdomain' ),
            'type' => 'checkbox',
          ),
          array(
            'id'   => $prefix . 'online',
            'name' => __( 'Online', 'textdomain' ),
            'type' => 'checkbox',
          ),
          array(
            'id'   => $prefix . 'gtm_link',
            'name' => __( 'GoToMeeting Link', 'textdomain' ),
            'type' => 'text',
            'class' => 'gtm-link',
            'visible' => array($prefix.'online', true)
          ),
          array(
            'id'   => $prefix . 'book',
            'name' => __( 'Book', 'textdomain' ),
            'type' => 'checkbox',
          ),
          array(
            'id' => $prefix . 'book-name',
            'name' => __('Name', 'textdomain'),
            'type' => 'text',
            'class' => 'ct-child-item',
            'visible' => array($prefix . 'book', true)
          ),
          array(
            'id' => $prefix . 'book-price',
            'name' => __('Price', 'textdomain'),
            'type' => 'text',
            'class' => 'ct-child-item',
            'visible' => array($prefix . 'book', true)
          ),
          array(
            'id' => $prefix . 'book-isbn',
            'name' => __('ISBN', 'textdomain'),
            'type' => 'text',
            'class' => 'ct-child-item',
            'visible' => array($prefix . 'book', true)
          ),
          array(
            'id'      => $prefix . 'level',
            'name'    => __( 'Level', 'textdomain' ),
            'type'    => 'select_advanced',
            'placeholder'  => 'Select level...',
            'options' => array( 'New User', 'Power User','Advanced User'),

          )
        )
      );

      // About this class meta box for the class post type
      $meta_boxes[] = array(
        'title' => __('About this class', 'textdomain'),
        'post_types' => 'class',
        'context' => 'normal',
        'fields' => array(
          array(
            'name' => __('Summary', 'textdomain'),
            'id' => $prefix . 'summary',
            'type' => 'textarea',
          ),
          array(
            'name' => __('Topics', 'textdomain'),
            'id' => $prefix . 'agenda',
            'type' => 'text',
            'clone' => true,
            'sort_clone' => true,
          ),
          array(
            'name' => __('Upload Agenda', 'textdomain' ),
            'id' => $prefix . 'agenda-upload',
            'type' => 'file',
        )
      )
    );

    // Audience profile meta box for the class post type
    $meta_boxes[] = array(
      'title' => __('Audience Profile', 'textdomain'),
      'post_types' => 'class',
      'context' => 'normal',
      'fields' => array(
        array(
          'name' => __('Who is it for?', 'textdomain'),
          'id' => $prefix . 'audience',
          'type' => 'textarea',
        ),
        array(
          'id' => $prefix . 'prereqs',
          'name' => __('Prerequisites', 'textdomain'),
          'type' => 'post',
          'post_type' => 'class',
          'clone' => true,
          'query_args' => array(
            'orderby' => 'title',
            'order' => 'ASC'
          )
        )
      )
    );

    // Price meta box for the class post type
    $meta_boxes[] = array(
      'title' => __('Price', 'textdomain'),
      'post_types' => 'class',
      'context' => 'side',
      'fields' => array(
        array(
          'name' => __('<strong><span style="width=5% !important;">$</span></strong>', 'textdomain'),
          'id' => $prefix . 'price',
          'class' => 'ct-meta-label',
          'type' => 'text',
        )
      )
    );

    // Parent class meta box for the event post type
    $meta_boxes[] = array(
      'title' => __('Parent Class', 'textdomain'),
      'post_types' => 'event',
      'context' => 'side',
      'fields' => array(
        array(
          'id' => $prefix . 'parent_class',
          'type' => 'post',
          'post_type' => 'class'
        )
      )
    );

      return $meta_boxes;
  }
  add_filter( 'rwmb_meta_boxes', 'ct_meta_boxes' );


// // Save the Metabox Data
// function ct_save_price_meta($post_id, $post) {
// 	// verify this came from the our screen and with proper authorization,
// 	// because save_post can be triggered at other times
// 	if ( !wp_verify_nonce( $_POST['classmeta_noncename'], plugin_basename(__FILE__) )) {
// 	return $post->ID;
// 	}
//
// 	// Is the user allowed to edit the post or page?
// 	if ( !current_user_can( 'edit_post', $post->ID ))
// 		return $post->ID;
//
// 	// OK, we're authenticated: we need to find and save the data
// 	// We'll put it into an array to make it easier to loop though.
//
// 	$price_meta['_price'] = $_POST['_price'];
//
// 	// Add values of $events_meta as custom fields
//
// 	foreach ($price_meta as $key => $value) { // Cycle through the $class_meta array!
// 		if( $post->post_type == 'revision' ) return; // Don't store custom data twice
// 		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
// 		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
// 			update_post_meta($post->ID, $key, $value);
// 		} else { // If the custom field doesn't have a value
// 			add_post_meta($post->ID, $key, $value);
// 		}
// 		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
// 	 }
//   }
//
//
// add_action('save_post', 'ct_save_price_meta', 1, 2); // save the custom fields


/*
  ==================================================================
    Customizes the messages that are displayed in the admin panel
  ==================================================================
*/
function ct_admin_notices() {
  $post = get_post();
  $post_type = get_post_type($post);
  if ($post_type == 'class') {
  $post_type_object = get_post_type_object($post_type);

  $messages['class'] = array(
    0 => '',
    1 => __('Class updated', 'textdomain'),
    2 => __('Custom field 2 updated', 'textdomain'),
    3 => __('Custom field 3 deleted', 'textdomain'),
    4 => __('Classes updated.', 'textdomain'),
    5 => isset( $_GET['revision'] ) ? sprintf(__('Class restored to revision from %s', 'textdomain'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => __('Class published', 'textdomain'),
    7 => __('Class saved', 'textdomain'),
    8 => __('Class submitted', 'textdomain'),
    9 => sprintf(__('Class scheduled for: <strong>%1$s</strong>', 'textdomain'),
          date_i18n(__('M j, Y @ G:i', 'textdomain'), strtotime( $post->post_date))),
    10 => __('Class draft updated')
  );

  if ( $post_type_object->publicly_queryable ) {
        $permalink = get_permalink( $post->ID );

        $view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View class', 'textdomain' ) );
        $messages[ $post_type ][1] .= $view_link;
        $messages[ $post_type ][6] .= $view_link;
        $messages[ $post_type ][9] .= $view_link;

        $preview_permalink = add_query_arg( 'preview', 'true', $permalink );
        $preview_link      = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview class', 'textdomain' ) );
        $messages[ $post_type ][8] .= $preview_link;
        $messages[ $post_type ][10] .= $preview_link;
    }

    return $messages;
  }
}
add_filter( 'post_updated_messages', 'ct_admin_notices' );

/*
  ========================================
    Create Sidebar
  ========================================
*/
function ct_sidebar_setup() {

  register_sidebar(
    array(
      'name' => 'CT Sidebar',
      'id' => 'ct-sidebar',
      'class' => 'custom',
      'description' => 'Custom sidebar for Computer Tutors to sort through classes',
      'before_widget' => '<aside id="%1s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h1 class="widget-title">',
      'after_title' => '</h1>',
      )
    );
}
add_action('widgets_init', 'ct_sidebar_setup' );



// Custom events query
function ct_em_query(){
	$args = array(
		'post_type' => 'event',
		'posts_per_page' => 100,
		'meta_query' => array( 'key' => '_start_ts', 'value' => current_time('timestamp'), 'compare' => '>=', 'type'=>'numeric' ),
		'orderby' => 'meta_value_num',
		'order' => 'ASC',
		'meta_key' => '_start_ts',
		'meta_value' => current_time('timestamp'),
		'meta_value_num' => current_time('timestamp'),
		'meta_compare' => '>='
	);

	// The Query
	$query = new WP_Query( $args );

	// The Loop
	while($query->have_posts()):
	$query->next_post();
	$id = $query->post->ID;
	echo '<li>';
	echo get_the_title($id);
	echo ' - '. get_post_meta($id, '_event_start_date', true);
	echo '</li>';
	endwhile;

	// Reset Post Data
	wp_reset_postdata();
}
add_shortcode('em_wp_query','ct_em_query');

function ct_custom_em_query($id) {

  }

  	wp_reset_postdata();
