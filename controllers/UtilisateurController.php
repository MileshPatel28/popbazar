<?php

/**
 * Contrôleur Utilisateur qui permet de gérer les utilisateurs comme l'inscription, la connexion, la déconnexion, etc.
 */

class UtilisateurController

{

  private $utilisateur; // représente l'instance du modèle utilisateur

  public function __construct()
  {
    // Instancie le modèle Utilisateur
    require_once get_chemin_defaut('models/Utilisateur.php');
    $this->utilisateur = new Utilisateur(); // instance du modèle Utilisateur
  }

  public function connexion_index(){
    Session::deja_connecte();
    chargerVue("/utilisateur/connexion");
  }

  public function inscription_index(){
    Session::deja_connecte();
    chargerVue("/utilisateur/inscription");
    inspecter('test','message test');
  }

  
  public function inscription(){
    $bin_inscription = true;


    $nom = obtenirParametre("nom");
    $prenom = obtenirParametre("prenom");

    $nom_utilisateur = obtenirParametre("nom_utilisateur");

    $email = obtenirParametre("email");

    $mot_de_passe = obtenirParametre("mot_passe");
    $confirmation_mot_passe = obtenirParametre("confirmation_mot_passe");

    if($mot_de_passe != $confirmation_mot_passe){
      $bin_inscription = false;
    }

    if($bin_inscription){
      // Ajout requête pour inscrire
      
    }
  }
  
  public function connexion(){
    $bin_connexion = true;

    $email = obtenirParametre('email');
    $mot_de_passe = obtenirParametre('mot_passe');

    if(Validation::valider_email($email) != false) $bin_connexion = true; 

    
    $utilisateur = $this -> utilisateur -> obtenir_utilisateur_email($email);
    $bin_connexion = password_verify($mot_de_passe,$utilisateur["mot_de_passe_hash"]);


    if($bin_connexion){
      Session::set('id_utilisateur',$utilisateur);
      redirect("/");
    }
    else{
      redirect("/connexion");
    }
  }

  public function deconnexion(){
    Session::detruire();
    Session::demarrer();
    redirect("/");
  }


}
