<?php

/**
 * Controleur qui gère les opérations liées au profil utilisateur
 */

class ProfilController
{

  public function __construct() {}

  public function afficher($params)
  {
    if(Session::est_connecte()){
      var_dump('profil');
    }
    else{
      redirect('/connexion');
    }
  }
}
