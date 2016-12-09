<?php
/*
 * Template Name: Formule
 * Description: Formule page
 */

$context = Timber::get_context();
include "common-elements.php";
include "mail-config.php";

if(isset($_POST['formule'])) {
    $to = get_option( 'admin_email' );
    $subject = 'Prise de contact';

    echo 'deco'.$_POST['deco'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $jour = $_POST['jour'];
    $mois = $_POST['mois'];
    $rencontre = $_POST['rencontre'];
    $lieu = $_POST['lieu'];
    $occasion = $_POST['occasion'];
    $nombre = $_POST['nombre'];
    $evjour = $_POST['ev-jour'];
    $evmois = $_POST['ev-mois'];
    $autre = $_POST['autre'];
    $min = $_POST['minBudget'];
    $max = $_POST['maxBudget'];
    $deco = $_POST['deco'] == 'on' ? 'Oui' : 'Non';
    $orga = $_POST['orga'] == 'on' ? 'Oui' : 'Non';
    $bonus = $_POST['bonus'];

    $message = "nom: $nom
    prenom: $prenom
    tel: $tel
    email: $email
    date de rencontre: $jour/$mois
    rencontre: $rencontre
    lieu de l'evenement: $lieu
    occasion: $occasion
    nombre d'invites: $nombre
    date de l'evenement: $evjour/$evmois
    Budget: de $min à $max euros
    Décoration: $deco
    Organisation: $orga
    Bonus: $bonus
    Autres details: $autre";

    $mail->addAddress('lessoeurs.senmelent@gmail.com', 'Les soeurs');     // Add a recipient
    $mail->addReplyTo($_POST["email"], '$prenom $nom');
  
    $mail->Subject = "$subject $prenom $nom";
    $mail->Body    = $message;

    if(!$mail->send()) {
        $context['confirmation'] = -1;
    } else {
        $context['confirmation'] = 1;
    }
}

$context['post'] = new TimberPost();
$context['categories'] = Timber::get_terms('category');

$context['form'] = Timber::get_post(52);

Timber::render('page-formule.twig', $context);
