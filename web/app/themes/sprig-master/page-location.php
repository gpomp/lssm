<?php
/*
 * Template Name: Location
 * Description: Location page
 */


$context = Timber::get_context();
include "common-elements.php";

$context['post'] = new TimberPost();

$args = array(
    'post_type' => 'objet-cat'
);

query_posts($args);
$context['categories'] = Timber::get_posts($args);


Timber::render('page-location.twig', $context);
