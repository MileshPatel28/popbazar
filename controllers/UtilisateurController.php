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
    var_dump('connexion');

    $bin_connexion = true;

    $email = obtenirParametre('email');
    $mot_de_passe = obtenirParametre('mot_passe');

    $bin_connexion = Validation::valider_email($email);

    $utilisateur = $this -> utilisateur -> obtenir_utilisateur_email($email);

    
  }


}
