<div class="col overflow-auto h-100">
    <div class="bg-light border rounded-3 p-3">
        <h2>Vue d'ensemble des prêts de clés TBT</h2>

        <!-- Spacer -->
        <div class='p-3'></div>
        
        <!-- Users tables -->
        <div>
            <table class="table table-hover align-middle" style='text-align: center;'>
                <thead>
                    <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Local TBT</th>
                    <th scope='col'>Prestataire</th>
                    <th scope='col'>Donneur d'ordre</th>
                    <th scope='col'>Sortie le</th>
                    <th scope='col'>Retour prévu le</th>
                    <th scope='col'></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        use App\controller\TbtController;

                        $count = 0; 
                        $actual_date = date('Y-m-d');
                    ?>
                    <?php foreach($this->loanedTbt as $key => $val) { ?>
                        <?php $count = $count + 1; ?>
                        
                        <tr>
                            <?php $outdated = false; if($actual_date > $val->getDatePrev()) { $outdated = true; }?>
                            <th><?= $count; ?></th>
                            <td><?= $val->getLocal(); ?></td>
                            <td><?= $val->getProvider(); ?></td>
                            <td><?= $val->getOrderGiver(); ?></td>
                            <td><?= $val->getDateSort(); ?></td>
                            <?php if($outdated) { ?>
                                <td class='text-danger'><strong><?= $val->getDatePrev(); ?></strong></td>
                            <?php } else { ?>
                                <td><?= $val->getDatePrev(); ?></td>
                            <?php } ?>
                            <td>
                                <a href='./?action=tbt_global&loan_id=<?= $val->getID(); ?>' class='btn btn-outline-info' title="Informations/Modifications"><i class='fa fa-info-circle'></i></a>
                                &nbsp;
                                <a href='.?action=tbt_global&loan_id=<?= $val->getID(); ?>&confirmRestitute' class='btn btn-outline-success' title="Restitution de la clé"><i class='fa fa-arrow-right'></i></a>
                            </td>    
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<div>


<!-- Show modal depend on the URL params -->
<?php if(isset($_GET['loan_id'])) { ?>
    <?php if(!isset($_GET['confirmRestitute'])) { ?>
        <script type="text/javascript">
            $(window).on('load', function() {
                $('#modificationModal_TBT').modal('show');
            });
        </script>
    <?php } ?>
<?php } ?>

<?php if(isset($_GET['confirmRestitute'])) { ?>
    <script type="text/javascript">
        $(window).on('load', function() {
            $('#confirmRestitute_modal').modal('show');
        });
    </script>
<?php } ?>

<?php
    if(isset($_GET['loan_id'])) {
        $actual_tbt = TbtController::getInstance()->getTbtByID($_GET['loan_id']); 
    }
?>


<!-- Restitute check modal -->
<div class='modal fade' id='confirmRestitute_modal' data-bs-backdrop='static' tabindex='-1' role='dialog' aria-labelledby="confirmRestitute_modalTitle" aria-hidden="true">
    <div class='modal-dialog modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='confirmRestituteTitle'>Êtes-vous sûr de vouloir restituer la clé ?</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>

            <div class='modal-body'>
                <div class='container'>
                    <div class="row">
                        <div class="col-12">
                            <h6>Restituer une clé est <strong>définitif</strong> et aucun retour en arrière ne sera possible !</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type='button' class='btn btn-outline-secondary'>Retour</button>
                <a href='./?action=tbt_confirmedRestitute&loan_id=<?= $_GET['loan_id']; ?>' class="btn btn-success">J'en suis sûr</a>
            </div>
        </div>
    </div>
</div>


<!-- Modifications check modal -->
<div class="modal fade" id="modificationModal_TBT" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Informations sur <strong><?= $actual_tbt->getLocal(); ?></strong></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-floating">
                            <input class="form-control" value="<?= $actual_tbt->getLocal(); ?>" type="text" readonly>
                            <label for="floatingInput">Nom du local</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input class="form-control" value="<?= $actual_tbt->getProvider(); ?>" type="text" readonly>
                            <label for="floatingInput">Fournisseur</label>
                        </div>
                    </div>
                    
                    <div class='p-2'></div>

                    <div class="col-6">
                        <div class="form-floating">
                            <input class="form-control" value="<?= $actual_tbt->getContact(); ?>" type="text" readonly>
                            <label for="floatingInput">Contact</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input class="form-control" value="<?= $actual_tbt->getOrderGiver(); ?>" type="text" readonly>
                            <label for="floatingInput">Donneur d'ordre</label>
                        </div>
                    </div>
                    
                    <div class='p-2'></div>

                    <div class="col-6">
                        <div class="form-floating">
                            <textarea class="form-control" type="text" readonly><?= $actual_tbt->getDesc(); ?></textarea>
                            <label for="floatingInput">Description des travaux</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input class="form-control" value="<?= $actual_tbt->getDateSort(); ?>" type="text" readonly>
                            <label for="floatingInput">Date de sortie</label>
                        </div>
                    </div>

                    <div class='p-2'></div>

                    <form method='POST'>
                        <div class="col-12">
                            <div class="form-floating">
                                <?php $outdated = false; if(date('Y-m-d') > $actual_tbt->getDatePrev()) { $outdated = true; }?>

                                <?php if($outdated) { ?>
                                    <div class="form-floating border border-danger rounded">
                                        <input class="form-control" value="<?= $actual_tbt->getDatePrev(); ?>" type="date" name='datePrev_TBT__modif'>
                                        <label for="floatingInput" class='text-danger'><strong>Date prévisionnnel</strong></label>
                                    </div>
                                <?php } else { ?>
                                    <div class="form-floating border border-success rounded">
                                        <input class="form-control" value="<?= $actual_tbt->getDatePrev(); ?>" type="date" name='datePrev_TBT__modif'>
                                        <label for="floatingInput" class='text-success'><strong>Date prévisionnnel</strong></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Accepter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Closing the 'main' and 'div' balise from dect/sidebar.php -->
</div>
</main>
