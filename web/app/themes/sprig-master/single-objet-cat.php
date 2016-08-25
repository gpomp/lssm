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

$_SESSION['locCat'] = $context['post']->id;
$_SESSION['locCatName'] = $context['post']->title;

$args = array(
    'post_type' => 'objet',
    'posts_per_page' => 12,
    'paged' => $params["paged"],
    'meta_query' => array(
        array(
            'key' => 'categorie',
            'value' => $context['post']->id,
            'compare' => 'IN'
        )
    )
);

query_posts($args);
$context['posts'] = Timber::get_posts($args);
$context['pagination'] = Timber::get_pagination();


Timber::render('page-locvente-cat.twig', $context);
