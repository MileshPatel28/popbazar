<?php

/**
 * Classe Annonce
 * Modèle pour gérer les utilisateurs dans la base de données
 */

class Utilisateur
{
  private $bd; // Connexion à la base de données

  public function __construct()
  {
    $config = require get_chemin_defaut('config/bd.php');
    require_once get_chemin_defaut('config/Database.php');

    $this->bd = new Database($config); // Instance de la classe Database
  }


  public function obtenir_utilisateur_id($id_utilisateur){
    return $this -> bd -> requete(
      "SELECT * FROM utilisateurs WHERE id = :id",
      [
        "id" => $id_utilisateur
      ]
    ) -> fetch();
  }

  public function obtenir_utilisateur_email($email){
    return $this -> bd -> requete(
      "SELECT * FROM utilisateurs WHERE email = :email",
      [
        "email" => $email
      ]
    ) -> fetch();
  }
}
