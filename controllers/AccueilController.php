<?php

/** 
AcceuilController.php - Controlleur acceuil.
 
Ce fichier permet à controller tous les actions
en liens avec la page d'acceuil.
 
@author Milesh Patel 
*/

class AccueilController
{


  public function index()
  {

    chargerVue("accueil", [
      "titre" => "Accueil",
    ]);
  }
}
