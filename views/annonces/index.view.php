<!-- Inclure l'entête ici -->

<?php
chargerVuePartielle('_entete');
?>

<!-- Inclure la navigation ici -->
<?php
chargerVuePartielle('_nav');
?>

<!-- Main Content -->
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Accueil</a></li>

            <li class="breadcrumb-item active"> <?= $nom_categorie ?> </li>
        </ol>
    </nav>

    <div class="section-header">
        <h2><i class="fas fa-bullhorn me-2"></i><?= $nom_categorie ?></h2>
    </div>

    <!-- Action Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <ul class="nav nav-pills tab-pills">
            <li class="nav-item">
                <a class="nav-link active" href="/annonces"> Toutes ( <?=$nombre_totale_annonce?> )</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/annonces?selection=actives"> Actives ( <?=$nombre_active_annonce?> )</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/annonces?selection=vendues"> Vendues ( <?=$nombre_vendues_annonce?> )</a>
            </li>
        </ul>


        
        <a href="/annonces-ajouter" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Créer une annonce
        </a>
    </div>
    <div class="row">
        <!-- Boucle pour afficher toutes les annonces -->
        <!-- Pour chaque annonce -->
        <?php foreach ($annonces_page as $index => $annonce) { ?>
            
            <!-- Listings -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="listing-status">
                        <span class="badge bg-success"> <?= ($annonce["est_actif"] == 1) ? 'Active' : 'Inactive' ?> </span>
                    </div>
                    <div class="listing-actions">
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/annonces/<?=$annonce["id"]?>"><i class="fas fa-eye me-2"></i>Voir</a></li>

                                <?php if(isset($id_utilisateur)){?>
                                <?php   if($id_utilisateur == $annonce["utilisateur_id"]) { ?>
                                <li><a class="dropdown-item" href="/annonces/<?=$annonce["id"]?>/modifier"><i class="fas fa-edit me-2"></i>Modifier</a></li>
                                <li>

                                    <!-- Formulaire pour marquer comme vendu -->
                                    <?php if($annonce["est_vendu"] == 0){ ?>
                                    <form id="form-vendue" method="POST" action="/annonces/<?=$annonce["id"]?>">
                                        <input type="hidden" name="est_vendu" value="1">
                                        <button class="dropdown-item text-danger" type="submit"><i class="fas fa-check-circle me-2"></i>Marquer comme vendu</button>
                                    </form>
                                    <?php } ?>

                                </li>
                                <?php } ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                
                                <li>
                                    <form method="POST" action="/annonces/<?=$annonce["id"] ?>/supprimer">
                                        <button class="dropdown-item text-danger" type="submit"><i class="fas fa-trash-alt me-2"></i>Supprimer</button>
                                    </form>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <img src="/images/300x200.png" class="card-img-top" alt="PS5">
                    <div class="card-body">
                        <h5 class="card-title"><?= $annonce["titre"] ?></h5>
                        <div class="mb-2">
                            <span class="price-tag"><?= $annonce["prix"] ?></span>
                            <span class="badge bg-primary ms-2"><!-- Afficher la catégorie de l'annonce --></span>
                            <span class="badge bg-secondary ms-2"> <?= $annonce["etat"] ?></span>
                            <!-- Si le produit est vendu -->
                             <?php if($annonce["est_vendu"] == 1) {?>
                                <span class="badge bg-danger text-light ms-2">Vendu</span>
                             <?php }?>
                            <!-- Fin si -->
                        </div>
                        <p class="card-text"><?= $annonce["description"] ?></p>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Publiée <?= il_y_a($annonce["date_creation"])?></small>
                            <span class="text-muted"><i class="fas fa-eye me-1"></i> <?= $annonce["nombre_vues"]?></span>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Fin de la boucle -->
        <?php } ?>
    </div>




    <!-- Empty Listings State (Hidden) -->
    <div class="empty-listings" style="display: none;">
        <i class="fas fa-tag"></i>
        <h3>Aucune annonce publiée</h3>
        <p class="text-muted mb-4">Vous n'avez pas encore publié d'annonces.</p>
        <a href="/annonces/ajouter" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Créer ma première annonce
        </a>
    </div>

    <!-- Pagination -->
    
    <nav aria-label="Page navigation" class="mt-4">
        <?php if(count($annonces_page) > 9) { ?>
        <ul class="pagination justify-content-center">

            <!-- Lien vers la page précédente -->
            <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>" >
                <a class="page-link" href="?page=<?= $page - 1 ?><?= (isset($selection) && $selection != null) ? "&selection=$selection" : ((isset($filter) && $filter != null) ? "&filter=$filter" : '')  ?>" tabindex="-1" aria-disabled="<?= ($page == 1) ? true : false ?>">Précédent</a>
            </li>

            <!-- Liens pour chaque page -->
            <?php for($i = 1; $i <= count($annonces) / 9; $i++){ ?>
            <!-- Boucle pour chaque page -->
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?><?= (isset($selection) && $selection != null) ? "&selection=$selection" : ((isset($filter) && $filter != null) ? "&filter=$filter" : '')  ?>"><?= $i ?></a>
                </li>
            <!-- Fin de la boucle -->
            <?php } ?>
            <!-- Lien vers la page suivante -->
            <li class="page-item <?= ($page == $i - 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?><?= (isset($selection) && $selection != null) ? "&selection=$selection" : ((isset($filter) && $filter != null) ? "&filter=$filter" : '')  ?>" aria-disabled="<!-- true si dernière page, sinon false -->">Suivant</a>
            </li>

        </ul>
        <?php } ?>
    </nav>
    
</div>

<script>
    const activerSelection = (element) => {
        const liens = document.querySelectorAll('.nav-link');
        liens.forEach(lien => {
            lien.classList.remove('active');
        });
        element.classList.add('active');
    }
</script>

<!-- Inclure le pied de page ici -->
<?php
chargerVuePartielle('_pied_page');
?>