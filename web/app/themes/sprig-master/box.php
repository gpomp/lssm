<?php
/*
 * Template Name: Box
 * Description: Box page
 */

$context = Timber::get_context();
include "common-elements.php";

if(isset($_POST['box'])) {
    $to = get_option( 'admin_email' );
    $subject = 'Prise de contact';


    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $box = $_POST['box'];

    $message = "nom: $nom
    prenom: $prenom
    tel: $tel
    email: $email
    box: $box";

    $headers = 'From: lessoeurs.senmelent@gmail.com' . "\r\n" .
    'Reply-To: lessoeurs.senmelent@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    
    if(mail($to, $subject, $message, $headers)) {
        $context['confirmation'] = 1;
    } else {
        $context['confirmation'] = -1;
    }
    

}

$post = new TimberPost();
$context['post'] = $post;
Timber::render('box.twig', $context);
