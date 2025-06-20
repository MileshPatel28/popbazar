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
    
    $page = (obtenirParametre("page") == null) ? 1 : obtenirParametre("page");
    $annonces = $this -> annonce -> get_annonces();
    $annonces_page = $this -> annonce -> get_annonces($page);


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
      "annonces_page" => $annonces_page,
      "nombre_totale_annonce" => $nombre_totale_annonce,
      "nombre_active_annonce" => $nombre_active_annonce,
      "nombre_vendues_annonce" => $nombre_vendues_annonce,
      "page" => $page,
      "selection" => $option_selectionner
    ]);
  }


  // A faire filter la liste dependant de l'utilisateur et bien tester
  public function index_utilisateur(){

    if(Session::est_connecte()){
      $id_utilisateur = Session::obtenir_id_utilisateur();

      $option_selectionner = obtenirParametre("filter");
      $page = (obtenirParametre("page") == null) ? 1 : obtenirParametre("page");


      $annonces = $this -> annonce -> get_annonces_utilisateur($id_utilisateur);
      $annonces_page = $this -> annonce -> get_annonces_utilisateur($id_utilisateur,$page);


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
  
  
  
      $nom_categorie = "Toutes";
      
      chargerVue('annonces/index', [
        "nom_categorie" => $nom_categorie,
        "annonces" => $annonces,
        "annonces_page" => $annonces_page,
        "nombre_totale_annonce" => $nombre_totale_annonce,
        "nombre_active_annonce" => $nombre_active_annonce,
        "nombre_vendues_annonce" => $nombre_vendues_annonce,
        "id_utilisateur" => $id_utilisateur,
        "page" => $page,
        "filter" => $option_selectionner
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


  public function index_ajouter($erreurs = []){

    if(Session::est_connecte()){
      chargerVue('annonces/ajouter',[
        "erreurs" => $erreurs
      ]);
    }
    else{
      redirect('/connexion');
      Session::set_flash("Vous devez être connecté pour créer une annonce.");
    }

  }

  public function ajouter(){
    require_once get_chemin_defaut('models/Categorie.php');
    require_once get_chemin_defaut('models/Annonce.php');

    $liste_erreurs = [];

    $id_utilisateur = Session::obtenir_id_utilisateur();

    $categorie = new Categorie();
    $id_categorie = $categorie->get_categorie_par_nom(obtenirParametre('categorie'))["id"];

    $titre = obtenirParametre('titre');
    $description = obtenirParametre('description');
    $prix = obtenirParametre('prix');
    $etat = obtenirParametre('etat');

    if(strlen($titre) > 70){
      array_push($liste_erreurs,"Le titre doit être au maximum 70 caractères.");
    }

    if(strlen($description) < 30){
      array_push($liste_erreurs,"Le description doit être au moins 30 caractères.");
    }

    if($liste_erreurs == []){
      $this -> annonce -> ajout_annonce($id_utilisateur,$id_categorie,$titre,$description
      ,$prix,$etat);

      redirect('/annonces/' . ($this -> annonce -> obtenir_annonce_ajouter()["id"]));
    }
    else{
      $this -> index_ajouter($liste_erreurs);
    }

  }



  public function index_modifier($donnes,$erreurs = []){

    require_once get_chemin_defaut('models/Categorie.php');

    $categorie = new Categorie();

    if(Session::est_connecte() && Session::obtenir_id_utilisateur() == $this -> annonce -> get_annouce_par_id($donnes["id"])["utilisateur_id"]){
      chargerVue('annonces/modifier',[
        "annonce" => $this -> annonce -> get_annouce_par_id($donnes["id"]),
        "categorie" => $categorie -> get_categorie($this -> annonce -> get_annouce_par_id($donnes["id"])["categorie_id"]),
        "erreurs" => $erreurs
      ]);
    }
    else if(Session::est_connecte()){
      redirect('/');
      Session::set_flash("Vous n'êtes pas autorisé à modifier cette annonce.");
    }
    else{
      redirect('/connexion');
      Session::set_flash("Vous devez être connecté pour modifier une annonce.");
    }
  }


  public function modifier($donnes){
    require_once get_chemin_defaut('models/Categorie.php');

    $id_annonce = intval($donnes["id"]);
    $est_vendu = obtenirParametre('est_vendu');

    if(isset($est_vendu) && $est_vendu == 1){

      $this -> annonce -> update_annonce_vendues($id_annonce,$est_vendu);

      redirect('/annonces/' . $id_annonce);
    }
    else{

      $liste_erreurs = [];

      $categorie = new Categorie();
      $id_categorie = $categorie->get_categorie_par_nom(obtenirParametre('categorie'))["id"];
  
      $titre = obtenirParametre('titre');
      $description = obtenirParametre('description');
      $prix = obtenirParametre('prix');
      $etat = obtenirParametre('etat');


      if(strlen($titre) > 70){
        array_push($liste_erreurs,"Le titre doit être au maximum 70 caractères.");
      }
  
      if(strlen($description) < 30){
        array_push($liste_erreurs,"Le description doit être au moins 30 caractères.");
      }
  
      
      if($liste_erreurs == []){
        $this -> annonce -> update_annonce($id_annonce,$id_categorie,$titre,$description,$prix,$etat);
        redirect('/annonces/' . $id_annonce);
      }
      else{
        $this -> index_modifier(["id" => $id_annonce],$liste_erreurs);
      }

    
    }
  }


  public function supprimer($donnes){
    $id_annonce = intval($donnes["id"]);
    $annonce = $this -> annonce -> get_annouce_par_id($id_annonce);

    if($annonce != null && $annonce["utilisateur_id"] == Session::obtenir_id_utilisateur()){
      $this -> annonce -> supprimer_annonce($id_annonce);
      redirect('/annonces');
      Session::set_flash("Annonce supprimée avec succès.");
    }
    else{
      redirect('/mes-annonces');
      Session::set_flash("L'annonce n'a pas pu être supprimée.",'error');
    }

  }
}
