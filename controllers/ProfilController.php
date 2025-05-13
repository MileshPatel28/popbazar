<?php

/** 
ProfilController.php - Controlleur de profil.
 
Ce fichier contrôle tous qui est en liens
avec l'affichage du profile de l'utilisateur.
 
@author Milesh Patel 
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
