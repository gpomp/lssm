<?php
/*
 * Template Name: Formule
 * Description: Formule page
 */

$context = Timber::get_context();
include "common-elements.php";

if(isset($_POST['formule'])) {
    $to = get_option( 'admin_email' );
    $subject = 'Prise de contact';


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
    $formule = $_POST['formule'];
    $autre = $_POST['autre'];

    $message = "nom: $nom<br/>
                prenom: $prenom<br/>
                tel: $tel<br/>
                email: $email<br/>
                date de rencontre: $jour/$mois<br/>
                rencontre: $rencontre<br/>
                lieu de l'evenement: $lieu<br/>
                occasion: $occasion<br/>
                nombre d'invites: $nombre<br/>
                date de l'evenement: $evjour/$evmois<br/>
                Formule: $formule<br/>
                Autres details: $autre<br/>
    ";

    
    if(mail($to, $subject, $message)) {
        $context['confirmation'] = 1;
    } else {
        $context['confirmation'] = -1;
    }
    

}

$context['post'] = new TimberPost();

$context['form'] = Timber::get_post(52);

Timber::render('page-formule.twig', $context);
