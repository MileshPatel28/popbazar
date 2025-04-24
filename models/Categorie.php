<?php

/**
 * Classe Annonce
 * Modèle pour gérer les annonces par categorie dans la base de données
 * 
 */
class Categorie
{
  private $bd; // Connexion à la base de données
  private $categorie;
  private $tableau_annonces;


  public function __construct($id_categorie)
  {
    $config = require get_chemin_defaut('config/bd.php');
    require_once get_chemin_defaut('config/Database.php');

    $this->bd = new Database($config);  // Instance de la classe Database 

    $stm = $this-> bd -> requete(
      'SELECT * FROM categories WHERE id = :id',
      ["id" => $id_categorie]
    );

    $this -> categorie = $stm -> fetch();

    $this -> tableau_annonces = $this -> bd -> requete(
      'SELECT * FROM produits WHERE categorie_id = :id',
      ["id" => $id_categorie]
    ) -> fetchAll();

  }

  public function get(){
    return $this -> categorie;
  }

  public function get_tableau_annonces(){
      return $this -> tableau_annonces;
  }
}
