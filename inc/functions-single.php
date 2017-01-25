<?php
/* Generates a list of upcoming dates for a class

*/

function get_single_style(){
  wp_enqueue_style('level-style', plugin_dir_url(__FILE__) . 'css/single.css');
  wp_enqueue_style('sidebar-style', plugin_dir_url(__FILE__) . 'css/cert-sidebar.css');
}
  add_action('wp_enqueue_scripts', 'get_single_style');
function ct_upcoming_dates($post) {
  ?>
  <div class="row">
  <div class="col-xs-12">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Class</th>
          <th>Date(s)</th>
        </tr>
      </thead>
      <tbody>

  <?php
      $args = array(
      'post_type' => 'event',
      'posts_per_page' => 100,
      'meta_key' => 'ct_parent_class',
      'meta_value' => $post->ID,
      'orderby' => '_event_start_date',
      'order' => 'ASC',

    );
    $i = 1;
    $query = new WP_Query($args);
    if ($query->have_posts()) {
    while($query->have_posts()):
    $query->next_post();
    $id = $query->post->ID;
    echo '<tr><td>'.$i++.'</td>';
    echo '<td><a href="'.get_the_permalink($id).'">'.get_the_title($id).'</a></td>';
    $class_start_date = get_post_meta($id, '_event_start_date', true);

    $class_start_date_format = str_replace('/', '-', $class_start_date);

    $startday = date('jS', strtotime($class_start_date_format));

    $startmonth = date('F ', strtotime($class_start_date_format));

    $startyear = date('Y', strtotime($class_start_date_format));

    $class_end_date = get_post_meta($id, '_event_end_date', true);

    $class_end_date_format = str_replace('/', '-', $class_end_date);

    $endday = date('jS', strtotime($class_end_date_format));

    $endmonth = date('F ', strtotime($class_end_date_format));

    $endyear = date('Y', strtotime($class_end_date_format));

    if ($class_start_date != $class_end_date && $startmonth != $endmonth) {

      echo '<td>'.$startmonth . $startday . ' - ' . $endmonth . $endday . ', ' . $endyear . '</td>';

      }
      elseif ($class_start_date != $class_end_date && $startmonth == $endmonth) {

        echo '<td>' . $startmonth . $startday . ' - ' . $endday . ', ' . $endyear . '</td>';
      }
      else {
        echo '<td> ' . $startmonth . $startday . ', ' . $startyear . '</td>';
      }
      echo '</tr>';
    endwhile;
  }
  else {
    echo '<tr><td colspan="3">This class is not scheduled at this time. Call 850-668-4090 to request this class.</td></tr>';
  }
  	wp_reset_postdata();
    echo '</tbody></table>';
}

/*
  ============================================================================================
    Looks for other levels of a class such as new, power, or advanced user and displays them
  ============================================================================================
*/
function ct_sister_pages($post) {
  if (get_post_meta($post->ID,'ct_standalone', true) == false) {
    $query = new WP_Query(array(
      'post_type' => 'class',
      'post_parent' => $post->post_parent,
      'orderby' => 'ct_level',
      'order' => 'ASC'
       )
    );
    if ( $query->found_posts > 1 ) {
      ?>
      <div class="ct-sister-classes">
      <?php
      echo '<p>Other levels:&nbsp;&nbsp;';

     $posts = $query->posts;

     $i = 0;

     foreach ($posts as $querypost) {
       $id = $querypost->ID;
       $level = get_post_meta($id, 'ct_level');
       $link = get_the_permalink($id);

       if ($i != 0) {
         echo '  &nbsp; | &nbsp;  ';
       }

       if ($level[0] == '0') {
         if ($link == get_the_permalink()) {
           echo '<strong>New User</strong>'.var_dump($level);
          }
         else {
           echo '<a href="'.$link.'" class="ctlink">New User</a>';
         }
       }
       if ($level[0] == '1') {
         if ($link == get_the_permalink()) {
           echo '<strong>Power User</strong>';
           }
         else {
           echo '<a href="'.$link.'" class="ctlink">Power User</a>';
         }
       }
       if ($level[0] == '2') {
         if ($link == get_the_permalink()) {
           echo '<strong>Advanced User</strong>';
            }
         else {
           echo '<a href="'.$link.'" class="ctlink">Advanced User</a>';
         }
       }
       $i++;
     }
     ?> </p></div>
     <?php
   }
  }
}
 ?>
