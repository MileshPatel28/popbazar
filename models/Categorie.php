<?php

/**
 * Classe Annonce
 * Modèle pour gérer les annonces par categorie dans la base de données
 * 
 */
class Categorie
{
  private $bd; // Connexion à la base de données
  private $tableau_categorie;


  public function __construct($id_categorie)
  {
    $config = require get_chemin_defaut('config/bd.php');
    require_once get_chemin_defaut('config/Database.php');

    $this->bd = new Database($config);  // Instance de la classe Database 

    $stm = $this-> bd -> requete(
      'SELECT * FROM categories WHERE id = :id',
      ["id" => $id_categorie]
    );

    $this -> tableau_categorie = $stm -> fetch();

  }

  public function get(){
    return $this -> tableau_categorie;
}
}
