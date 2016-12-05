<?php
/*
 * Template Name: Location
 * Description: Services page
 */


$context = Timber::get_context();
include "common-elements.php";

$context['post'] = new TimberPost();

$args = array(
    'post_type' => 'service-cat'
);

query_posts($args);
$context['categories'] = Timber::get_posts($args);


Timber::render('page-services.twig', $context);
