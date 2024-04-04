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

function FCNP__addStyles(){
  if(!is_single() || 'post' != get_post_type()) return;
  wp_enqueue_style('next-post-style', plugin_dir_url(__FILE__) . 'style.css', array(), filemtime(plugin_dir_path(__FILE__) . 'style.css'), false);
}
add_action('wp_enqueue_scripts', 'FCNP__addStyles');

// This function adds the next button
function FCNP__addPostButtons(){
  // getting the current post's ID
  $cuttentId = get_the_ID();
  // including the template file for the buttons
  include_once 'inc/buttons.php';
}
add_action('genesis_after_entry_content', 'FCNP__addPostButtons');

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
  // return if no id supplied
  if(!isset($id)) return;
  // return if the direction is using the incorect format
  if(!in_array($direction, array('after', 'before'))) return;
  // setting up the query
  $queryArgs = array(
    'post_type' => 'post',
    'posts_per_page' => 1,
    'orderby' => 'date',
    'post__not_in' => array($id),
  );
  // setting the order based on the direction param
  if($direction === 'before'){
    // before needs to be descending
    $order = 'DESC';
  } else{
    // otherwise it needs to be ascending
    $order = 'ASC';
  }
  // setting order param on query
  $queryArgs['order'] = $order;
  // setting the date query, if the direction variable exists
  if(!empty($direction)){
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