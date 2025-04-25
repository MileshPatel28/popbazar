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

$routeur->post("/annonces","AnnonceController@ajouter");
