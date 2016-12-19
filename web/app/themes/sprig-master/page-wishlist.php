<?php
/*
 * Template Name: Wishlist
 * Description: Wishlist page
 */

$context = Timber::get_context();
include "common-elements.php";
include "mail-config.php";

$context['post'] = new TimberPost();



if(isset($_POST['del'])) {
  $del = -1;
  for ($i=0; $i < count($_SESSION['objectList']); $i++) { 
    if($_SESSION['objectList'][$i]['id'] == $_POST['del']) {
      $del = $i;
      break;
    }
  }

  if($del != -1) {
    array_splice($_SESSION['objectList'], $del, 1);
  }
}

$context['form_name'] = '';
$context['form_surname'] = '';
$context['form_email'] = '';


if(isset($_SESSION['objectList']) && count($_SESSION['objectList']) > 0) {
  $ids = array();
  $nbs = array();
  $types = array();
  for ($i=0; $i < count($_SESSION['objectList']); $i++) { 
    array_push($ids, $_SESSION['objectList'][$i]['id']);
    array_push($nbs, $_SESSION['objectList'][$i]['nb']);
    array_push($types, $_SESSION['objectList'][$i]['type']);
  }

  $context['posts'] = Timber::get_posts($ids);
  $context['nbs'] = $nbs;
  $context['types'] = $types;

  if(isset($_POST['send']) && $_POST['send'] == 1 && isset($_POST['tos']) && $_POST['tos'] == 'on') {
    if(isset($_POST['yoyo']) && $_POST['yoyo'] == 'yoyo4325435654654') {

      $message = "Liste de ";

      $message .= $_POST["surname"] . " ";
      $message .= $_POST["lastname"] . "\n";
      $message .= "email: " . $_POST["email"] . "\n\n";

      $message .= "Bonjour\nMerci de votre confiance. Nous vous contacterons très bientôt pour conclure votre commande. Voici la liste des produits :\n\n";
      $allIDs = array();
      for ($i=0; $i < count($_SESSION['objectList']); $i++) { 
        array_push($allIDs, $_SESSION['objectList'][$i]['id']);
      }

      $objectsToSend = Timber::get_posts($allIDs);
      $total = 0;

      for ($i=0; $i < count($objectsToSend); $i++) { 

        $locVente = ($_SESSION['objectList'][$i]['type'] == 0) ? "Location de" : "Achat de";
        $price = (int)(($_SESSION['objectList'][$i]['type'] == 0) ? $objectsToSend[$i]->prix_de_location : $objectsToSend[$i]->prix_de_vente) * $_SESSION['objectList'][$i]['nb'];

        $messagePart = $locVente . " " . $_SESSION['objectList'][$i]['nb'] . " produits pour " . $price . "€\n\n";

        $message .= "ID: ".$_SESSION['objectList'][$i]['id'] . "\nNom: " . $objectsToSend[$i]->post_title . "\n" . $messagePart;

        $total += $price;
      }

      $message .= "\n Prix Total: $total euros";

      $mail->addAddress('lessoeurs.senmelent@gmail.com', 'Les soeurs');     // Add a recipient
      $mail->addAddress($_POST["email"], 'Les soeurs');     // Add a recipient
      $mail->addReplyTo('lessoeurs.senmelent@gmail.com', 'Email Client');
      
      $mail->Subject = 'Nouvelle Commande sur les soeurs s\'en melent';
      $mail->Body    = $message;

      if(!$mail->send()) {
        $context['messageSent'] = 2;
        $context['mailError'] = $mail->ErrorInfo;
      } else {
        $_SESSION['objectList'] = array();

        $context['messageSent'] = 1;
      }
    }
  } else {
    if(isset($_POST['send']) && $_POST['send'] == 1 && (!isset($_POST['tos']) || $_POST['tos'] != 'on')) {
      $context['error'] = 2;

      $context['form_name'] = $_POST["lastname"];
      $context['form_surname'] = $_POST["surname"];
      $context['form_email'] = $_POST["email"];
    }
  }

} else {
  $context['error'] = 1;
  
}


Timber::render('page-wishlist.twig', $context);
