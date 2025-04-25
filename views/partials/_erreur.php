<!-- Vue partielle : erreurs.php -->

<!-- Condition : si le tableau des erreurs n'est pas vide -->
 <?php if($donnees != []) { ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <h5 class="alert-heading">
    <i class="fas fa-exclamation-circle me-2"></i>
    <!-- Afficher "Des erreurs sont survenues" si plus d'une erreur, sinon "Une erreur est survenue" -->
    Des erreurs sont survenues
  </h5>

  <ul class="mb-0 list-unstyled">
    <!-- Boucle pour chaque erreur dans le tableau des erreurs -->
     <?php foreach($donnees as $message_erreur){ ?> 
    <li><i class="fas fa-times-circle me-2"></i><?= $message_erreur ?></li>
    <?php } ?>
    <!-- Fin de la boucle -->
  </ul>

  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
</div>
<?php } ?>
<!-- Fin de la condition -->