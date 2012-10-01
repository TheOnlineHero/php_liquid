<?php
/*
Plugin Name: Liquid PHP
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Allows you to add {{site_url}} liquid tag into your stylesheets and posts to print your sites url. 
Use liquid_stylesheet_url() in your header.php template instead of bloginfo( 'stylesheet_url' ) to parse your stylesheet.

When you want to use site_url in your stylesheet or post, use it like this:
Example:
body {
  background: url({{site_url}}/test_image.png)
}


Please use the override_mytheme_liquid_array() function to override the liquid variables that you want in your stylesheets and posts.
Example:
function override_mytheme_liquid_array() {
		return array('site_url' => get_option('siteurl'), "dude" => "tom");
}
Best place to write this method is in your themes functions.php template.


Version: 1.0
Author: Tom Skroza
Author URI: 
License: GPL2
*/

function liquid_stylesheet_url() {
	echo get_option('siteurl')."/wp-content/plugins/php_liquid/style.php";
}

function liquid() {
	require_once('harrydeluxe-php-liquid/Liquid.class.php');
	define('PROTECTED_PATH', dirname(__FILE__).'/harrydeluxe-php-liquid/example/protected/');
	$liquid = new LiquidTemplate(PROTECTED_PATH.'templates/');
	$cache = array('cache' => 'file', 'cache_dir' => PROTECTED_PATH.'cache/');
	//$cache = array('cache' => 'apc');
	$liquid->setCache($cache);
	return $liquid;
}

function mytheme_liquid_content_filter( $content ) {
		$liquid = liquid();
    $liquid->parse($content);
    
    if (function_exists( 'override_mytheme_liquid_array' )) {
      $assigns = override_mytheme_liquid_array();
    } else {
      $assigns = array('site_url' => get_option('siteurl'));
    }
		
		return $liquid->render($assigns);
}
add_filter( 'the_content', 'mytheme_liquid_content_filter',2 );


?>