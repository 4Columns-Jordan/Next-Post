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

/**
 * This function gets the next or previous post based on the
 * supplied ID, and direction parameter. Defaults to next post.
 * 
 *  @param $id - INT - Current post ID
 *  @param $direction - Direction of the query, defaults to after
 *  @return null or STR - Returns null if no posts or no id param,
 *  otherwise ir returns a string of the post url
 */
function FCNP__getPostUrl($id = null, $direction = 'after'){
  if(!isset($id)) return;
  // setting up the query
  $queryArgs = array(
    'post_type' => 'post',
    'posts_per_page' => 1,
    'orderby' => 'date',
    'order' => 'ASC',
    'post__not_in' => array($id),
  );
  // setting the date query, if the direction variable exists
  // and it's a string
  if(!empty($direction) && is_string($direction)){
    // set the date query with the direction param
    $queryArgs['date_query'] = array(
      array(
        $direction => get_the_date('Y-m-d H:i:s', $id),
    ),
  );
  }
  // getting the private category
  $privateCat = get_category_by_slug('private');
  // if the private category exists, exclude it from the query
  if(!empty($privateCat))
    $queryArgs['category__not_in'] = $privateCat->term_id;
  // making a new query
  $postQuery = new WP_Query($queryArgs);
  // if the query is not empty
  if(!empty($postQuery->posts)){
    // get the post id
    $postID = $postQuery->posts[0]->ID;
    // get the permalink
    $permaLink = get_the_permalink($postID);
    return $permaLink;
  }
  // return null if there are no posts
  return null;
}