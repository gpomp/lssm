<?php
/*
 * Template Name: Box
 * Description: Box page
 */

$context = Timber::get_context();
include "common-elements.php";

$post = new TimberPost();
$context['post'] = $post;
Timber::render('box.twig', $context);
