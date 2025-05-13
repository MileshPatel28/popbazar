<?php

/** 
CategorieController.php - Controlleur des catégories 
 
Ce fichier contrôle les actions en liens avec 
les catégories , comme afficher tous les 
jeux vidéos.
 
@author Milesh Patel 
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
    $page = (obtenirParametre("page") == null) ? 1 : obtenirParametre("page");
    $annonces = $this -> categorie -> get_annonces($param["id"]);
    $annonces_page = $this -> categorie -> get_annonces($param["id"],$page);


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
      "annonces_page" => $annonces_page,
      "nombre_totale_annonce" => $nombre_totale_annonce,
      "nombre_active_annonce" => $nombre_active_annonce,
      "nombre_vendues_annonce" => $nombre_vendues_annonce,
      "page" => $page
    ]);
  }
}
