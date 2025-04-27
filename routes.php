<?php

/**
 * Routes
 * 
 * Ce fichier contient la liste des routes de l'application
 * 
 * Chaque route est associée à un contrôleur et une méthode de controlleur
 * 
 * exemple : $routeur->get("/annonces", "AnnonceController@index")
 *           $routeur->get("/annonces/{id}", "AnnonceController@afficher");
 */

$routeur->get("/", "AccueilController@index");


$routeur->get("/categories/{id}/annonces","CategorieController@index");
$routeur->get("/annonces","AnnonceController@index_defaut");
$routeur->get("/mes-annonces","AnnonceController@index_utilisateur");

$routeur->get("/annonces/{id}","AnnonceController@afficher");

$routeur->get("/annonces-ajouter","AnnonceController@index_ajouter");
$routeur->post("/annonces","AnnonceController@ajouter");

$routeur->get("/annonces/{id}/modifier","AnnonceController@index_modifier");
$routeur->post("/annonces/{id}","AnnonceController@modifier");

$routeur->post("/annonces/{id}/supprimer","AnnonceController@supprimer");

$routeur->get("/connexion","UtilisateurController@connexion");

// $routeur->get("");