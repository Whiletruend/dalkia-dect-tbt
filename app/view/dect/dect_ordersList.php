<?php
    use App\controller\DectController;
?>

<!-- Table -->
<div class="col overflow-auto h-100">
    <div class="bg-light border rounded-3 p-3">
        <button type='button' class='btn btn-outline-danger float-right' data-bs-toggle='modal' data-bs-target='#ordersCheck_modal'><i class='fas fa-trash'></i> Vider le tableau</button>
        <h2>Liste des commandes</h2>
        <p>Voici une vue d'ensemble de toutes les commandes à passer. Vous pouvez les copier et également vider le tableau afin de repartir à 0.</p>

    
        <!-- Orders tables -->
        <div class="bg-white border rounded-3 p-3">
            <div>
                <table class="table table-hover align-middle" style='text-align: center;'>
                    <thead>
                        <tr>
                            <th scope='col'>N°</th>
                            <th scope='col'>Pièces</th>
                            <th scope='col'>Références</th>
                            <th scope='col'>Date demande</th>
                            <th scope='col'>SDI / Compas</th>
                            <th scope='col'>Ancien FAN</th>
                            <th scope='col'>CA</th>
                            <th scope='col'>Qté</th>
                            <th scope='col'>Nom MRT</th>
                            
                            <!-- Asked 6 void spacer for the table -->
                            <th scope='col'>&nbsp;</th>
                            <th scope='col'>&nbsp;</th>
                            <th scope='col'>&nbsp;</th>
                            <th scope='col'>&nbsp;</th>
                            <th scope='col'>&nbsp;</th>
                            <th scope='col'>&nbsp;</th>
                            <!-- The project manager asked to do this -->

                            <th scope='col'>Nom Client</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 0; ?>
                        <?php foreach($this->ordersList as $key => $val) { ?>
                            <?php $count = $count + 1; ?>
                            <tr>
                                <th scope='row'><?= $count ?></th>
                                <td><?= $val->getPiece(); ?></td>
                                <td><?= $val->getReference(); ?></td>
                                <td><?= $val->getDateDemande(); ?></td>
                                <td><?= $val->getSDI_Compas(); ?></td>
                                <td><?= $val->getOldFan(); ?></td>
                                <td><?= $val->getCA(); ?></td>
                                <td><?= $val->getQuantity(); ?></td>
                                <td><?= $val->getMRTName(); ?></td>

                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>

                                <td><?= $val->getClientName(); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Clear check -->
        <div class='modal fade' id='ordersCheck_modal' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='Êtes-vous sûr de vouloir vider le tableau ?' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='ordersCheck_modal_Title'>Êtes-vous sûr de vouloir vider le tableau ?</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Fermer'></button>
                    </div>

                    <div class='modal-body'>
                        <h6>Une fois validé, le tableau sera supprimé de manière <strong>définitive</strong> et aucun retour en arrière ne sera possible.</h6>
                    </div>

                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fermer</button>
                        <a class='btn btn-danger float-right' href='./?action=dect_clearOrders'>J'en suis sûr</a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>


<!-- Closing the 'main' and 'div' balise from dect/sidebar.php -->
</div>
</main>
