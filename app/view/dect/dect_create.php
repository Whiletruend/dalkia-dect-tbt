<?php
    use App\controller\DectController;
    use App\controller\UserController;
?>

<div class="col overflow-auto h-100">
    <div class="bg-light border rounded-3 p-3">
        <h2>Création d'un DECT</h2>
        <p>Choisissez de créer un nouveau DECT de manière intuitive.</p>
        <div class='p-2'></div>
            <!-- idk for now -->
            <div class="bg-white border rounded-3 p-3">
                <div>
                    <form class='row g-3' method='POST'>
                        <!-- N° Appel & Modèle -->
                        <div class="col-md-6">
                            <label for="appel_DECT" class="form-label">N° Appel</label>
                            <input type="text" style='text-transform: uppercase;' class="form-control" name='appel_DECT__add' id="appel_DECT__add" required>
                        </div>
                        <div class="col-md-6">
                            <label for="type_DECT" class="form-label">Modèle</label>
                            <?php $dect_Models = DectController::getInstance('')->getEveryDectModels(); ?>
                            <select class="form-select" name='type_DECT__add' id='type_DECT__add' required>
                                <?php foreach($dect_Models as $key => $val) { ?>
                                    <option value='<?= $val->getModele(); ?>'><?= $val->getModele(); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <!-- N° Série & Dati -->
                        <div class="col-md-6">
                            <label for="numserie_DECT" class="form-label">N° Série</label>
                            <input type="text" style='text-transform: uppercase;' class="form-control" name='numserie_DECT__add' id="numserie_DECT__add" required>
                        </div>
                        <div class="col-md-6" required>
                            <label for="isDati_DECT" class="form-label">DATI ?</label>
                            <select class="form-select" name='isDati_DECT__add' id='isDati_DECT__add' required>
                                <option value='0'>Non</option>
                                <option value='1'>Oui</option>
                            </select>
                        </div>

                        <!-- N° Embauche & CA -->
                        <div class="col-md-6">
                            <label for="embauche_UTILISATEUR" class="form-label">N° Embauche</label>
                            <input type="text" style='text-transform: uppercase;' class="form-control" name='embauche_UTILISATEUR_DECT__add' id="embauche_UTILISATEUR_DECT__add" required>
                        </div>
                        <div class="col-md-6" required>
                            <label for="ca_UTILISATEUR" class="form-label">CA</label>
                            <input type="text" style='text-transform: uppercase;' class="form-control" name='ca_UTILISATEUR_DECT__add' id="ca_UTILISATEUR_DECT__add" required>
                        </div>
                        <div class='col-md-12'>
                            <!-- Retry button -->
                            <a href='./?action=dect_create'><button type='button' class="btn btn-secondary">Recommencer</button></a>

                            <!-- Create button -->
                            <button type="submit" class="btn btn-success float-right">Valider la création</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Closing the 'main' and 'div' balise from users/sidebar.php -->
</div>
</main>