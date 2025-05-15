<?php

/** 
Utilisateur.php - Interface à BD pour utilisateurs
 
Ce fichier sert a une interface pour communiquer à la 
base de donnée pour tous les données liés à une utilisateur
comme leur email,id,etc...
 
@author Milesh Patel 
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

  public function inserer_utilisateur($nom_utilisateur,$email,$mot_de_passe_hash,$prenom,$nom){
    $this -> bd -> requete(
      "INSERT INTO utilisateurs (nom_utilisateur,email,mot_de_passe_hash,prenom,nom)
        VALUES (:nom_utilisateur,:email,:mot_de_passe_hash,:prenom,:nom)",
        [
          "nom_utilisateur" => $nom_utilisateur,
          "email" => $email,
          "mot_de_passe_hash" => $mot_de_passe_hash,
          "prenom" => $prenom,
          "nom" => $nom
        ]
      );
  }
}
