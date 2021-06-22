<?php
    use App\controller\TbtController;
    use App\controller\UserController;
?>

<div class="col overflow-auto h-100">
    <div class="bg-light border rounded-3 p-3">
        <h2>Prêt d'une clé TBT</h2>
        <p>Choisissez de créer un nouveau DECT de manière intuitive.</p>
        <div class='p-2'></div>
            <!-- idk for now -->
            <div class="bg-white border rounded-3 p-3">
                <div>
                    <form class='row g-3' method='POST'>
                        <!-- Local & Entreprise -->
                        <div class="col-md-6">
                            <label for="local_TBT" class="form-label">Local TBT</label>
                            <select class="form-select" name='local_TBT__add' id='local_TBT__add' required>
                                <?php foreach($this->everyTbt as $key => $val) { ?>
                                    <option value='<?= $val->getNom(); ?>'><?= $val->getNom(); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6" required>
                            <label for="company_TBT" class="form-label">Entreprise</label>
                            <select class="form-select" name='company_TBT__add' id='company_TBT__add' required>
                                <?php foreach($this->providers as $key => $val) { ?>
                                    <option value='<?= $val->getNom(); ?>'><?= $val->getNom(); ?></option>
                                <?php } ?>
                            </select>
                        </div>

      
                        
                        <!-- Contact & Donneur d'ordre -->
                        <div class="col-md-6" required>
                            <label for="contact_TBT" class="form-label">Contact entreprise</label>
                            <input type="text" style='text-transform: uppercase;' class="form-control" name='contact_TBT__add' id="contact_TBT__add" required>
                        </div>

                        <div class="col-md-6" required>
                            <label for="orderGiven_TBT" class="form-label">Donneur d'ordres</label>
                            <select class="form-select" name='orderGiver_TBT__add' id='orderGiver_TBT__add' required>
                                <?php foreach($this->orderGivers as $key => $val) { ?>
                                    <option value='<?= $val->getNom(); ?>'><?= $val->getNom(); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Description & Date retour -->
                        <div class="col-md-6" required>
                            <label for="desc_TBT" class="form-label">Description des travaux</label>
                            <textarea type="text" style='text-transform: uppercase;' class="form-control" rows='3' name='desc_TBT__add' id="desc_TBT__add" required></textarea>
                        </div>
                        <div class="col-md-6" required>
                            <label for="date_TBT" class="form-label">Date de retour:</label>
                            <input type="date" style='text-transform: uppercase;' class="form-control" name='date_TBT__add' id="date_TBT__add" required>
                        </div>


                        <div class='col-md-12'>
                            <!-- Retry button -->
                            <a href='./?action=tbt_loan'><button type='button' class="btn btn-secondary">Recommencer</button></a>

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