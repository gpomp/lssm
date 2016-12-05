<?php
/*
 * Description: Location page
 */
global $params;

if(!isset($params["name"])) {
   $params["name"] = 0;
}

if(!isset($params["paged"])) {
    $params["paged"] = 0;
}

$context = Timber::get_context();
include "common-elements.php";

$context['post'] = new TimberPost();

$_SESSION['servCat'] = $context['post']->id;
$_SESSION['servCatName'] = $context['post']->title;

$args = array(
    'post_type' => 'service',
    'posts_per_page' => 12,
    'paged' => $params["paged"],
    'meta_query' => array(
        array(
            'key' => 'type',
            'value' => $context['post']->id,
            'compare' => 'IN'
        )
    )
);

query_posts($args);
$context['posts'] = Timber::get_posts($args);
$context['pagination'] = Timber::get_pagination();


Timber::render('page-services-cat.twig', $context);
