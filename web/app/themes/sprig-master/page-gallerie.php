<?php
/*
 * Template Name: Gallerie
 * Description: Gallerie page
 */

global $paged;
global $params;
if (!isset($paged) || !$paged){
    $paged = 1;
}

if(isset($params['paged'])) {
    $paged = $params['paged'];
}

$context = Timber::get_context();

include "common-elements.php";

$args = array(
    'post_type' => array('projet'),
    'posts_per_page' => 50,
    'paged' => $paged
);
query_posts($args);

$posts = Timber::get_posts($args);

$context['post'] = new TimberPost();

$context['posts'] = $posts;

$context['pagination'] = Timber::get_pagination();

//Template name: Blog
Timber::render('page-gallerie.twig', $context);

?>
