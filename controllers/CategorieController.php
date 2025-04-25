<?php

/**
 * Controleur qui gère les opérations liées aux annonces par catégories
 * 
 */
class CategorieController
{

  private $categorie; // représente l'instance du modèle Categorie

  public function __construct()
  {
    // Instancie le modèle Annonce
    require_once get_chemin_defaut('models/Categorie.php');
    $this->categorie = new Categorie(); // instance du modèle Categorie
  }

  public function index($param){
    $nombre_totale_annonce = 0;
    $nombre_active_annonce = 0;
    $nombre_vendues_annonce = 0;


    chargerVue('annonces/index', [
      "id_categorie" => $param["id"]
    ]);
  }
}
