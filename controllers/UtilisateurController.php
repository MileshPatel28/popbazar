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

  public function inscription_index($donnes){
    Session::deja_connecte();
    chargerVue("/utilisateur/inscription",[
      "erreurs" => $donnes
    ]);
    inspecter('test','message test');
  }

  
  public function inscription(){
    $bin_inscription = true;

    $liste_erreurs = [];

    $nom = obtenirParametre("nom");
    $prenom = obtenirParametre("prenom");

    $nom_utilisateur = obtenirParametre("nom_utilisateur");

    $email = obtenirParametre("email");

    $mot_de_passe = obtenirParametre("mot_passe");
    $confirmation_mot_passe = obtenirParametre("confirmation_mot_passe");

    if($mot_de_passe != $confirmation_mot_passe){
      $bin_inscription = false;
      array_push($liste_erreurs,"Le mot de passe n'est pas le même que le mot de passe de confirmation.");
    }

    if(strlen($nom) < 2 || strlen($nom) > 50){
      $bin_inscription = false;
      array_push($liste_erreurs,"Le nom doit comporter entre 2 et 50 caractères.");
    }

    if(strlen($prenom) < 2 || strlen($prenom) > 50){
      $bin_inscription = false;
      array_push($liste_erreurs,"Le prenom doit comporter entre 2 et 50 caractères.");
    }

    if(strlen($nom_utilisateur) < 4 || strlen($nom_utilisateur) > 50){
      $bin_inscription = false;
      array_push($liste_erreurs,"Le nom d'utilisateur doit avoir entre 4 et 50 caractères.");
    }



    if(!strlen($mot_de_passe) >= 8){
      $bin_inscription = false;
      array_push($liste_erreurs,"Le mot de passe doit contenir au moins 8 caractères.");
    }
    if(!preg_match('/[A-Z]/',$mot_de_passe)){
      $bin_inscription = false;
      array_push($liste_erreurs,"Le mot de passe doit contenir au moins une lettre majuscule.");
    }
    if(!preg_match('/[0-9]/',$mot_de_passe)){
      $bin_inscription = false;
      array_push($liste_erreurs,"Le mot de passe doit contenir au moins un chiffre.");
    }
    if(!preg_match('/[^a-zA-Z0-9]/',$mot_de_passe)){
      $bin_inscription = false;
      array_push($liste_erreurs,"Le mot de passe doit contenir au moins un caractère spécial.");
    }
    

    if($bin_inscription){
      $this -> utilisateur -> inserer_utilisateur(
        $nom_utilisateur,
        $email,
        password_hash($mot_de_passe,PASSWORD_DEFAULT),
        $prenom,
        $nom
      );
      redirect('/');
    }
    else{
      $this -> inscription_index($liste_erreurs);
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
