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

  if(isset($_POST['send']) && $_POST['send'] == 1) {
    if(isset($_POST['yoyo']) && $_POST['yoyo'] == 'yoyo4325435654654') {

      $message = "Liste de ";

      $message .= $_POST["surname"] . " ";
      $message .= $_POST["lastname"] . "\n";
      $message .= "email: " . $_POST["email"] . "\n\n";

      $message .= "Produits:\n\n";
      $allIDs = array();
      for ($i=0; $i < count($_SESSION['objectList']); $i++) { 
        array_push($allIDs, $_SESSION['objectList'][$i]['id']);
      }

      $objectsToSend = Timber::get_posts($allIDs);

      for ($i=0; $i < count($objectsToSend); $i++) { 

        $locVente = ($_SESSION['objectList'][$i]['type'] == 0) ? "Louer" : "Acheter";

        $message .= "ID: ".$_SESSION['objectList'][$i]['id'] . "\nNom: " . $objectsToSend[$i]->post_title . "\n$locVente x" . $_SESSION['objectList'][$i]['nb'] . "\n\n";
      }

      $mail->addAddress('lessoeurs.senmelent@gmail.com', 'Les soeurs');     // Add a recipient
      $mail->addReplyTo($_POST["email"], 'Email Client');
      
      $mail->Subject = 'Nouvelle Commande';
      $mail->Body    = $message;

      if(!$mail->send()) {
        $context['messageSent'] = 2;
        $context['mailError'] = $mail->ErrorInfo;
      } else {
        $_SESSION['objectList'] = array();

        $context['messageSent'] = 1;
      }
    }
  }

} else {
  $context['error'] = 1;
}


Timber::render('page-wishlist.twig', $context);
