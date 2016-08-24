<?php
/*
 * Template Name: Location Vente Categorie
 * Description: Location page
 */
global $params;

if(!$params) {
    $params = array(-1, 0);
}

if(count($params) < 2) {
    array_push($params, 0);
}

$context = Timber::get_context();
include "common-elements.php";

$_SESSION['locCat'] = $params["catd"];

$args = array(
    'post_type' => 'objet',
    'posts_per_page' => 12,
    'paged' => array_values($params)[1],
    'meta_query' => array(
        array(
            'key' => 'categorie',
            'value' => array_values($params)[0],
            'compare' => 'IN'
        )
    )
);

query_posts($args);
$context['posts'] = Timber::get_posts($args);
$context['pagination'] = Timber::get_pagination();


Timber::render('page-locvente-cat.twig', $context);
