<?php
/**
 * The Template for displaying all single actu
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

$ytID = array();
$url = get_field('video', $post);
preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $ytID);
$context['ytID'] = $ytID;

Timber::render(array('single-actu' . $post->ID . '.twig', 'single-actu' . $post->post_type . '.twig', 'single-actu.twig'), $context);


