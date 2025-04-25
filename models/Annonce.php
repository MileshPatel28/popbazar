<?php

/**
 * Classe Annonce
 * Modèle pour gérer les annonces dans la base de données
 * 
 */

class Annonce
{
  private $bd; // Connexion à la base de données

  public function __construct()
  {
    $config = require get_chemin_defaut('config/bd.php');
    require_once get_chemin_defaut('config/Database.php');

    $this->bd = new Database($config); // Instance de la classe Database 
  }


  public function get_annonces(){
      return $this -> bd -> requete(
        'SELECT * FROM produits'
      ) -> fetchAll();
  }

  public function ajout_annonce($utilisateur_id,$id_categorie,$titre,$description,$prix,$etat){
      
      $this -> bd -> requete(
        "INSERT INTO produits (utilisateur_id,categorie_id,titre,description,prix,etat)
          VALUES (:utilisateur_id,:categorie_id,:titre,:description,:prix,:etat)",
          [
            "utilisateur_id" => $utilisateur_id,
            "categorie_id" => $id_categorie,
            "titre" => $titre,
            "description" => $description,
            "prix" => $prix,
            "etat" => $etat
          ]
      );  
  }

}
