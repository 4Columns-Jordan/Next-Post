<?php
/*
Plugin Name: Next Post
Plugin URI: https://fourcolumns.net
Description: This plugin adds next and previous buttons on the posts.
Version: 0.0.1
Author: The Four Columns Team
Author URI: https: //fourcolumns.net
License: GPLv2
*/

// This function adds the next button
function FCNP__addNextButton(){
  // getting the private category
  $privateCat = get_category_by_slug('private');

  var_dump($privateCat->term_id);
  echo 'hello world';

  echo FCNP__getPostUrl();

}
add_action('genesis_after_entry_content', 'FCNP__addNextButton');

function FCNP__getPostUrl($id = null, $direction = 1){
  if(!isset($id)) return;
  // setting up the query
  $queryArgs = array(
    'post_type' => 'post',
    'posts_per_page' => 1,
    'orderby' => 'date',
    'order' => 'ASC',
    'date_query' => array(
      array(
        'after' => get_the_date('Y-m-d H:i:s', $id),
      ),
    ),
  );

  return $id;
}