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
