<?php

/** 
Annonce.php - Interface à la BD pour les annonces
 
Ce fichier sert a une interface pour faire des requête plus précis 
vers la base de donnée.
 
@author Milesh Patel 
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


  public function get_annonces($page = -1){
    if ($page != -1) {
      return $this->bd->requete(
        'SELECT * FROM produits 
        ORDER BY id LIMIT 9 OFFSET ' . ($page*9)
      )->fetchAll();
    }

    return $this->bd->requete(
      'SELECT * FROM produits'
    )->fetchAll();
  }

  public function get_annonces_utilisateur($id_utilisateur,$page = -1){
    if ($page != -1) {
      $annonce_pages = $this->bd->requete(
        'SELECT * FROM produits WHERE utilisateur_id = :utilisateur_id
        ORDER BY id LIMIT 9 OFFSET ' . ($page*9),
        ["utilisateur_id" => $id_utilisateur]
      )->fetchAll();

      if($annonce_pages != []) return $annonce_pages;
    }

    return $this->bd->requete(
      'SELECT * FROM produits WHERE utilisateur_id = :utilisateur_id',
      ["utilisateur_id" => $id_utilisateur]
    )->fetchAll();
  }

  public function get_annouce_par_id($id_categorie){
    return $this -> bd -> requete(
      'SELECT * FROM produits WHERE id = :id',
      ["id" => $id_categorie]
    ) -> fetch();
  }

  

  public function ajout_annonce($utilisateur_id,$id_categorie,$titre,$description,$prix,$etat){
      
      $this -> bd -> requete(
        "INSERT INTO produits (utilisateur_id,categorie_id,titre,description,prix,etat)
          VALUES (:utilisateur_id,:categorie_id,:titre,:description,:prix,:etat)",
          [
            "utilisateur_id" => intval($utilisateur_id),
            "categorie_id" => intval($id_categorie),
            "titre" => $titre,
            "description" => $description,
            "prix" => intval($prix),
            "etat" => $etat
          ]
      );  
  }

  public function update_annonce($annonce_id,$id_categorie,$titre,$description,$prix,$etat){
    $this -> bd -> requete(
        "UPDATE produits SET
        categorie_id = :categorie_id,
        titre = :titre,
        description = :description,
        prix = :prix,
        etat = :etat
        WHERE id = :id",
        [
          "categorie_id" => $id_categorie,
          "titre" => $titre,
          "description" => $description,
          "prix" => $prix,
          "etat" => $etat,
          "id" => $annonce_id
        ]
    ) -> execute();
  }

  public function update_annonce_vendues($annonce_id,$est_vendu){
    $this -> bd -> requete(
      "UPDATE produits SET
      est_vendu = :est_vendu
      WHERE id = :id",
      [
        "est_vendu" => $est_vendu,
        "id" => $annonce_id
      ]
    ) -> execute();
  }

  public function supprimer_annonce($annonce_id){
    $this -> bd -> requete(
      "DELETE FROM produits WHERE id = :id",
      [
        "id" => $annonce_id
      ]
    ) -> execute();
  }

  public function obtenir_annonce_ajouter(){
    return $this -> bd -> requete(
      "SELECT * FROM produits ORDER BY id DESC"
    ) -> fetch();
  }

}
