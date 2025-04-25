<?php

/**
 * Controller de qui gère les opérations liées aux annonces comme l'affichage, la création, la modification, la suppression, etc.
 * 
 */

class AnnonceController
{

  private $annonce; // représente l'instance du modèle Annonce

  public function __construct()
  {
    // Instancie le modèle Annonce
    require_once get_chemin_defaut('models/Annonce.php');
    $this->annonce = new Annonce(); // instance du modèle Annonce
  }

  public function index($donnes){

    
    $annonces = $this -> annonce -> get_annonces();

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

    $nom_categorie = "Toutes";
    
    chargerVue('annonces/index', [
      "nom_categorie" => $nom_categorie,
      "annonces" => $annonces,
      "nombre_totale_annonce" => $nombre_totale_annonce,
      "nombre_active_annonce" => $nombre_active_annonce,
      "nombre_vendues_annonce" => $nombre_vendues_annonce
    ]);
  }

}
