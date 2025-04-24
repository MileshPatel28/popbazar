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
    $nom_categorie = obtenir_nom_categorie($donnes["id"]);
    
    require_once get_chemin_defaut('models/Categorie.php');
    $categorie = new Categorie($donnes["id"]);

    chargerVue('annonces/index', [
      "obj_categorie" => $categorie->get()  
    ]);
  }

}
