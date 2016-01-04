<?php
/*
 * Template Name: Home
 * Description: Home page
 */

$context = Timber::get_context();
include "common-elements.php";

$context['post'] = new TimberPost();

$context['isHome'] = true;

$actuQuery = array(
    'post_type' => array('actu'),
    'numberposts' => 1,
    'orderby' => 'post_date',
    'order' => 'DESC'
);

$actu = Timber::get_posts($actuQuery);

$context['actu'] = $actu;

$projetQuery = array(
    'post_type' => array('projet'),
    'numberposts' => 1,
    'orderby' => 'post_date',
    'order' => 'DESC'
);

$projet = Timber::get_posts($projetQuery);

$context['projet'] = $projet;

Timber::render('home.twig', $context);
