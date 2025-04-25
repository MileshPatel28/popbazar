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

  public function index_defaut(){

    $option_selectionner = obtenirParametre("selection");

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

    $annonces = array_filter($annonces, function($annonce) use ($option_selectionner) {
      return ($option_selectionner == 'actives' && $annonce["est_actif"] == 1) ||
             ($option_selectionner == 'vendues' && $annonce["est_vendu"] == 1) ||
              $option_selectionner == null;
    });


    $nom_categorie = "Toutes";
    
    chargerVue('annonces/index', [
      "nom_categorie" => $nom_categorie,
      "annonces" => $annonces,
      "nombre_totale_annonce" => $nombre_totale_annonce,
      "nombre_active_annonce" => $nombre_active_annonce,
      "nombre_vendues_annonce" => $nombre_vendues_annonce
    ]);
  }


  // A faire filter la liste dependant de l'utilisateur et bien tester
  public function index_utilisateur(){

    if(Session::est_connecte()){
      $option_selectionner = obtenirParametre("filter");
      $id_utilisateur = Session::obtenir_id_utilisateur();

      $annonces = $this -> annonce -> get_annonces();
  
      $nombre_totale_annonce = 0;
      $nombre_active_annonce = 0;
      $nombre_vendues_annonce = 0;
  
  
      foreach($annonces as $index => $annonce){
        if($id_utilisateur == $annonce["utilisateur_id"]){
          $nombre_totale_annonce++;
  
          if($annonce["est_actif"] == 1) {
            $nombre_active_annonce++;
          }
          
          if($annonce["est_vendu"] == 1){
            $nombre_vendues_annonce++;
          }
        }
      }
  
      $annonces = array_filter($annonces, function($annonce) use ($option_selectionner,$id_utilisateur) {
        return (($option_selectionner == 'actives' && $annonce["est_actif"] == 1) ||
               ($option_selectionner == 'vendues' && $annonce["est_vendu"] == 1) ||
                $option_selectionner == null) && $annonce["utilisateur_id"] == $id_utilisateur;
      });
  
  
      $nom_categorie = "Toutes";
      
      chargerVue('annonces/index', [
        "nom_categorie" => $nom_categorie,
        "annonces" => $annonces,
        "nombre_totale_annonce" => $nombre_totale_annonce,
        "nombre_active_annonce" => $nombre_active_annonce,
        "nombre_vendues_annonce" => $nombre_vendues_annonce
      ]);
    }
    else{
      redirect('/');
    }

  }


  public function afficher($param){
    $annonces = $this -> annonce -> get_annonces();
    $annonce = null;

    foreach($annonces as $annonce_tmp){
      if($annonce_tmp["id"] == $param["id"]){
        $annonce = $annonce_tmp;
      }
    }

    if($annonce == null){
      redirect('/erreur');
    }

    require_once get_chemin_defaut('models/Categorie.php');
    $categorie = new Categorie(); 


    chargerVue('annonces/afficher', [
      "annonce" => $annonce,
      "categorie" => $categorie->get_categorie($annonce["categorie_id"])
    ]);
  }


  public function index_ajouter(){

    if(Session::est_connecte()){
      chargerVue('annonces/ajouter');
    }
    else{
      redirect('/connexion');
    }

  }

  public function ajouter(){
    // redirect('/annonces');
    var_dump(obtenirParametre('categorie'));
  }

}
