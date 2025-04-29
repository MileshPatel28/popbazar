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
    chargerVue("/utilisateur/connexion");
  }

  public function inscription_index(){
    chargerVue("/utilisateur/inscription");
  }

  
  
  public function connexion(){

    $bin_connexion = true;

    $email = obtenirParametre('email');
    $mot_de_passe = obtenirParametre('mot_passe');

    if(Validation::valider_email($email) != false) $bin_connexion = true; 

    
    $utilisateur = $this -> utilisateur -> obtenir_utilisateur_email($email);
    $bin_connexion = password_verify($mot_de_passe,$utilisateur["mot_de_passe_hash"]);


    if($bin_connexion){
      var_dump("connecté!!");
    }
    else{
      redirect("/connexion");
    }
  }


}
