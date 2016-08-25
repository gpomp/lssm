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

$idArray = array();
for ($i=0; $i < intval($post->produits_similaires); $i++) { 
  array_push($idArray, $post->{"produits_similaires_".$i."_objet"});
}

if(isset($_POST['add']) && $_POST['add'] == 0) {
  if(!isset($_SESSION['objectList'])) {
      $_SESSION['objectList'] = array();
    }
    
    if(!in_array($post->ID, $_SESSION['objectList'])) {
      $a = array(
        "id" => $id,
        "nb" => $_POST['nb'],
        "type" => $_POST['locvente']
      );
      array_push($_SESSION['objectList'], $a);
    }
    
}

if(isset($_SESSION['objectList']) && count($_SESSION['objectList']) > 0) {

  for ($i=0; $i < count($_SESSION['objectList']); $i++) { 
    if($post->ID == $_SESSION['objectList'][$i]['id']) {
      $context['inList'] = true;
      break;
    }
  }

  
}


$context['locCat'] = -1;
if(isset($_SESSION['locCat'])) {
  $context['locCat'] = $_SESSION['locCat'];
  $context['locCatName'] = $_SESSION['locCatName'];
}

// var_dump(get_object_vars($post));
$args = array(
    'post_type' => 'objet',
    'post__in' => count($idArray) == 0 ? [-1] : $idArray
);
query_posts($args);
$context['related_products'] = Timber::get_posts($args);

Timber::render(array('single-objet' . $post->ID . '.twig', 'single-objet' . $post->post_type . '.twig', 'single-objet.twig'), $context);


