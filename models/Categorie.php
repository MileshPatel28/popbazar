<?php

/**
 * Classe Annonce
 * Modèle pour gérer les annonces par categorie dans la base de données
 * 
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
    );
}
}
