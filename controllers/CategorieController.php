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

    $annonces = $this -> categorie -> get_annonces($param["id"]);
    $page = (obtenirParametre("page") == null) ? 1 : obtenirParametre("page");

    $nombre_totale_annonce = 0;
    $nombre_active_annonce = 0;
    $nombre_vendues_annonce = 0;

    foreach($annonces as $index => $annonce){
      $nombre_totale_annonce++;
      if($annonce["est_actif"] == 1) {
        $nombre_active_annonce++;
      }
      
      if($annonce["est_vendu"] == 1){
        $nombre_vendues_annonce++;
      }
    }
    
    chargerVue('annonces/index', [
      "nom_categorie" => $this -> categorie -> get_categorie($param["id"])["nom"],
      "annonces" => $annonces,
      "nombre_totale_annonce" => $nombre_totale_annonce,
      "nombre_active_annonce" => $nombre_active_annonce,
      "nombre_vendues_annonce" => $nombre_vendues_annonce,
      "page" => $page
    ]);
  }
}
