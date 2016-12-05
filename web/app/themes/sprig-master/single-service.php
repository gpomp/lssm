<?php
/**
 * The Template for displaying all single service
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
include "common-elements.php";

$post = Timber::query_post();
$context['post'] = $post;
$context['categories'] = Timber::get_terms('category');
/*$categories = $post->terms( 'category' );

// Get only the first category from the array
$context['category'] = reset( $categories );*/


$context['servCat'] = -1;
if(isset($_SESSION['servCat'])) {
  $context['servCat'] = $_SESSION['servCat'];
  $context['servCatName'] = $_SESSION['servCatName'];
}

Timber::render(array('single-service' . $post->ID . '.twig', 'single-service' . $post->post_type . '.twig', 'single-service.twig'), $context);


