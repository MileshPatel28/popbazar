<?php

/**
 * Controleur qui gère les opérations liées au profil utilisateur
 */

class ProfilController
{

  private $utilisateur;
  public function __construct() {
    require_once get_chemin_defaut('models/Utilisateur.php');
    $this -> utilisateur = new Utilisateur();
  }

  public function afficher($params){
    if(Session::est_connecte()){
      chargerVue("utilisateur/profil",
        ["utilisateur" => $this -> utilisateur -> obtenir_utilisateur_id(Session::obtenir_id_utilisateur())]
      );
    }
    else{
      redirect('/connexion');
    }
  }
}
