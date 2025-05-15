<?php

/** 
Categorie.php - Interface pour les catégories.
 
Ce fichier sert comme une interface pour communiquer à la base
de donnée pour tous les données liés au catégories.
 
@author Milesh Patel 
*/

class Categorie
{
  private $bd; // Connexion à la base de données


  public function __construct()
  {
    $config = require get_chemin_defaut('config/bd.php');
    require_once get_chemin_defaut('config/Database.php');

    $this->bd = new Database($config);  // Instance de la classe Database 
  }

  public function get_categorie($id_categorie){
    return $this-> bd -> requete(
      'SELECT * FROM categories WHERE id = :id',
      ["id" => $id_categorie]
    ) -> fetch();
  }

  public function get_annonces($id_categorie,$page = -1){
    if($page != -1){
      return $this -> bd -> requete(
        'SELECT * FROM produits WHERE categorie_id = :id
        ORDER BY id LIMIT 9 OFFSET ' . ($page*9),
        ["id" => $id_categorie]
      ) -> fetchAll();
    }

    return $this -> bd -> requete(
      'SELECT * FROM produits WHERE categorie_id = :id',
      ["id" => $id_categorie]
    ) -> fetchAll();
  }

  public function get_categorie_par_nom($nom_categorie){
    return $this-> bd -> requete(
      'SELECT * FROM categories WHERE nom = :nom',
      ["nom" => $nom_categorie]
    ) -> fetch();
  }
}
