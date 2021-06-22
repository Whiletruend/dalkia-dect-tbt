<div class="col overflow-auto h-100">
    <div class="bg-light border rounded-3 p-3">
        <h2>Vue d'ensemble des utilisateurs</h2>
        <p>Voici une vue d'ensemble de tous vos utilisateurs, vous pouvez effectuer des recherches, des ajouts, des modifications ou bien des suppresions.</p>
        <?php
            use App\controller\DectController;
            use App\controller\UserController;
            use App\model\Dect;

if($this->msg_type != '') {
        ?>
                <div class='p-2'></div>
                <div class="alert alert-<?= $this->msg_type; ?> alert-dismissible fade show" id='dect_SEARCH_alert' role="alert">
                    <strong>Erreur !</strong> <?= $this->msg_text; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <script>
                    $("#dect_SEARCH_alert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#dect_SEARCH_alert").slideUp(500);
                        window.location.replace("./?action=dect_global");
                    });
                </script>
            <?php } ?>
        <div class='p-2'></div> 
        
        <!-- Search bar -->
        <div>
            <form method='POST'>
                <div class="input-group mb-3">
                    <input type="text" name='dect_SEARCH' class="form-control" placeholder="Recherchez un DECT grâce à son n° appel, son n° embauche ou bien par un nom de famille" aria-label="Recherchez un DECT grâce à son n° appel, son n° embauche ou bien par un nom de famille">
                    <button class="btn btn-outline-primary" type="submit">Rechercher</button>
                </div>
            </form>
        </div>

        <div class='p-2'></div> <!-- Spacer -->
        
        <!-- Users tables -->
        <div>
            <table class="table table-hover align-middle" style='text-align: center;'>
                <thead>
                    <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>N° Appel</th>
                    <th scope='col'>Type</th>
                    <th scope='col'>Num Série</th>
                    <th scope='col'>DATI</th>
                    <th scope='col'>N° Embauche</th>
                    <th scope='col'>CA</th>
                    <th scope='col'></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0; ?>
                    <?php foreach($this->dectList as $key => $val) { ?>
                        <?php $count = $count + 1; ?>
                        <tr>
                            <th scope='row'><?= $count ?></th>
                            <td> <?= $val->getAppel(); ?> </td>
                            <td> <?= $val->getType(); ?> </td>
                            <td> <?= $val->getNumSerie(); ?> </td>
                            <?php
                                $dati_Bool = $val->getIsDati();

                                if(is_null($dati_Bool)) {
                                    $dati_Bool = 'Valeur nulle';
                                } elseif($dati_Bool == 1) {
                                    $dati_Bool = 'Oui';
                                } else {
                                    $dati_Bool = 'Non';
                                }
                            ?>
                            <td> <?= $dati_Bool; ?> </td>
                            <td> <?= $val->getEmbauche(); ?> </td>
                            <td> <?= $val->getCA(); ?> <div class='px-2'> </td>

                            <!-- Button that make the informations modal popup -->
                            <td><a href='<?= DectController::getInstance('')->isSearching($val->getEmbauche()) . '&numserie=' . $val->getNumSerie(); ?>' class='btn btn-outline-info'><i class='fa fa-info-circle'></i></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <!-- REDIRECTION BASED ON URL PARAMETERS -->
        <?php if(isset($_GET['emb'])) { ?>
            <?php if(!isset($_GET['dect_modifications'])) { ?>
                <?php if(!isset($_GET['dect_confirmDelete'])) { ?>
                    <?php if(!isset($_GET['dect_intervention'])) { ?>
                        <script type="text/javascript">
                            $(window).on('load', function() {
                                $('#dectInfos_modal').modal('show');
                            });
                        </script>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>

        <?php if(isset($_GET['dect_modifications'])) { ?>
            <script type="text/javascript">
                $(window).on('load', function() {
                    $('#dectModifs_modal').modal('show');
                });
            </script>
        <?php } ?>

        <?php if(isset($_GET['dect_confirmDelete'])) { ?>
            <script type="text/javascript">
                $(window).on('load', function() {
                    $('#dectCheckDelete_modal').modal('show');
                });
            </script>
        <?php } ?>

        <?php if(isset($_GET['dect_intervention'])) { ?>
            <script type="text/javascript">
                $(window).on('load', function() {
                    $('#dectIntervention_modal').modal('show');
                });
            </script>
        <?php } ?>
    
        <!-- DECT infos modal -->
        <div class="modal fade" tabindex="-1" id='dectInfos_modal' aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- Le PHP fait bug l'affichage du Footer. A régler !! -->
                        <h5 class="modal-title" id="exampleModalLabel">Informations sur <strong><?= "le DECT"; //$this->usersList[$_GET['emb']]->getNom(); ?></strong> <strong><?= ''; //$this->usersList[$_GET['emb']]->getPrenom(); ?></strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class='container'>

                            <?php 
                                $user = UserController::getInstance('')->getUserByEmb($_GET['emb']);
                                $dect = DectController::getInstance('')->getDectByNumSerie($_GET['numserie']);
                            ?>

                            <h5>Informations <strong>utilisateur</strong>:</h5>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input class="form-control" value="<?= $user->getNom(); ?>" type="text" name='recap_name_BUSINESS' readonly>
                                        <label for="floatingInput">Nom de l'utilisateur</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input class="form-control" value="<?= $user->getPrenom(); ?>" type="text" name='recap_name_BUSINESS' readonly>
                                        <label for="floatingInput">Prénom de l'utilisateur</label>
                                    </div>
                                </div>
                            </div>
                            <div class='p-2'></div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input class="form-control" value="<?= $user->getEmbauche(); ?>" type="text" name='recap_name_BUSINESS' readonly>
                                        <label for="floatingInput">Embauche</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input class="form-control" value="<?= $user->getCA(); ?>" type="text" name='recap_name_BUSINESS' readonly>
                                        <label for="floatingInput">CA de l'utilisateur</label>
                                    </div>
                                </div>
                            </div>

                            <div class='p-2'></div>

                            <h5>Informations <strong>DECT</strong>:</h5>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input class="form-control" value="<?= $dect->getAppel(); ?>" type="text" name='recap_name_BUSINESS' readonly>
                                        <label for="floatingInput">N° Appel</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input class="form-control" value="<?= $dect->getType(); ?>" type="text" name='recap_name_BUSINESS' readonly>
                                        <label for="floatingInput">Type</label>
                                    </div>
                                </div>
                            </div>
                            <div class='p-2'></div>
                            <div class="row">
                                <div class="col-6">
                                    <?php if(DectController::getInstance('')->isGuaranted($dect->getNumSerie())) { ?>
                                        <div class="form-floating border border-success rounded">
                                            <input class="form-control" value="<?= $dect->getNumSerie(); ?>" type="text" name='recap_name_BUSINESS' readonly>
                                            <label for="floatingInput" class='text-success'><strong>Numéro de série</strong></label>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-floating border border-danger rounded">
                                            <input class="form-control" value="<?= $dect->getNumSerie(); ?>" type="text" name='recap_name_BUSINESS' readonly>
                                            <label for="floatingInput" class='text-danger'><strong>Numéro de série</strong></label>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating">
                                        <?php
                                            $dati_Bool = $val->getIsDati();

                                            if(is_null($dati_Bool)) {
                                                $dati_Bool = 'Valeur nulle';
                                            } elseif($dati_Bool == 1) {
                                                $dati_Bool = 'Oui';
                                            } else {
                                                $dati_Bool = 'Non';
                                            }
                                        ?>
                                        <input class="form-control" value="<?= $dati_Bool; ?>" type="text" name='recap_name_BUSINESS' readonly>
                                        <label for="floatingInput">DATI</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <a href="<?= DectController::getInstance('')->isSearching($dect->getEmbauche()) . '&numserie=' . $dect->getNumSerie() . '&dect_confirmDelete'; ?>" dismiss='modal' class='btn btn-outline-danger mr-auto'>Supprimer</a>
                        <a href="<?= DectController::getInstance('')->isSearching($dect->getEmbauche()) . '&numserie=' . $dect->getNumSerie() . '&dect_intervention'; ?>" dismiss='modal' class='btn btn-outline-info'>Intervention</a>
                        <a href="<?= DectController::getInstance('')->isSearching($dect->getEmbauche()) . '&numserie=' . $dect->getNumSerie() . '&dect_modifications'; ?>" class='btn btn-outline-secondary'>Modifier</a>
                        <button type='button' class='btn btn-primary' data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- DECT modifs modal -->
        <div class="modal fade" tabindex="-1" id='dectModifs_modal' aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- Le PHP fait bug l'affichage du Footer. A régler !! -->
                        <h5 class="modal-title" id="exampleModalLabel">Informations sur <strong><?= "le DECT"; //$this->usersList[$_GET['emb']]->getNom(); ?></strong> <strong><?= ''; //$this->usersList[$_GET['emb']]->getPrenom(); ?></strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                        <?php 
                            $user = UserController::getInstance('')->getUserByEmb($_GET['emb']);
                            $dect = DectController::getInstance('')->getDectByNumSerie($_GET['numserie']);
                        ?>

                        <form method='POST'>
                            <div class="modal-body">
                                <div class='container'>
                                    <h5>Informations <strong>utilisateur</strong>:</h5>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input class="form-control" value="<?= $user->getNom(); ?>" type="text" name='nom_UTILISATEUR__update'>
                                                <label for="floatingInput">Nom de l'utilisateur</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input class="form-control" value="<?= $user->getPrenom(); ?>" type="text" name='prenom_UTILISATEUR__update'>
                                                <label for="floatingInput">Prénom de l'utilisateur</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='p-2'></div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input class="form-control" value="<?= $user->getEmbauche(); ?>" type="text" name='embauche_UTILISATEUR__update'>
                                                <label for="floatingInput">Embauche</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input class="form-control" value="<?= $user->getCA(); ?>" type="text" name='ca_UTILISATEUR__update'>
                                                <label for="floatingInput">CA de l'utilisateur</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class='p-2'></div>

                                    <h5>Informations <strong>DECT</strong>:</h5>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input class="form-control" value="<?= $dect->getAppel(); ?>" type="text" name='appel_DECT__update'>
                                                <label for="floatingInput">N° Appel</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <?php $dect_Models = DectController::getInstance('')->getEveryDectModels(); ?>
                                            <div class="form-floating">
                                                <select class="form-select" name='type_DECT__update' >
                                                    <?php foreach($dect_Models as $key => $val) { ?>
                                                        <?php if($val->getModele() == $dect->getType()) { ?>
                                                            <option value='<?= $dect->getType(); ?>' selected><?= $dect->getType(); ?></option>
                                                        <?php } else { ?>
                                                            <option value='<?= $val->getModele(); ?>'><?= $val->getModele(); ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>

                                                <label for="floatingInput">Modèle du DECT</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='p-2'></div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input class="form-control" value="<?= $dect->getNumSerie(); ?>" type="text" name='numserie_DECT__update'>
                                                <label for="floatingInput">Numéro de série</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <?php
                                                    $dati_Bool = $dect->getIsDati();
                                                    $dati_Possibilities = array('Valeur nulle', 'Oui', 'Non');

                                                    if(is_null($dati_Bool)) {
                                                        $dati_Bool = 'Valeur nulle';
                                                    } elseif($dati_Bool == 1) {
                                                        $dati_Bool = 'Oui';
                                                    } else {
                                                        $dati_Bool = 'Non';
                                                    }
                                                ?>

                                                <select class="form-select" name='isDati_DECT__update' >
                                                    <?php foreach($dati_Possibilities as $key => $val) { ?>
                                                        <?php if($val == $dati_Bool) { ?>
                                                            <option value='<?= $key; ?>' selected><?= $dati_Bool; ?></option>
                                                        <?php } else { ?>
                                                            <option value='<?= $key; ?>'><?= $val; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                                <label for="floatingInput">DATI</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <a href="<?= DectController::getInstance('')->isSearching($dect->getEmbauche() . '&numserie=' . $dect->getNumSerie()); ?>" class='btn btn-outline-secondary'>Retour</a>
                                <button type='submit' class='btn btn-primary'>Valider les changements</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- DECT delete modal -->
        <div class="modal fade" tabindex="-1" id='dectCheckDelete_modal' data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- Le PHP fait bug l'affichage du Footer. A régler !! -->
                        <h5 class="modal-title" id="exampleModalLabel">Êtes-vous sûr de vouloir <strong>supprimer</strong> le DECT ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <?php
                        $dect = DectController::getInstance('')->getDectByNumSerie($_GET['numserie']);
                    ?>

                    <div class="modal-body">
                        <div class='container'>
                            <div class="row">
                                <div class="col-12">
                                    <h6>Supprimer un DECT est <strong>définitif</strong> et aucun retour en arrière ne sera possible !</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href='<?= DectController::getInstance('')->isSearching($dect->getEmbauche()) . '&numserie=' . $dect->getNumSerie(); ?>' class="btn btn-outline-secondary">Retour</a>
                        <a href='./?action=dect_delete&numserie=<?= $dect->getNumSerie(); ?>' class="btn btn-danger">J'en suis sûr</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- DECT intervention modal -->
        <div class="modal fade" tabindex="-1" id='dectIntervention_modal' aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- Le PHP fait bug l'affichage du Footer. A régler !! -->
                        <h5 class="modal-title" id="exampleModalLabel">Intervention sur un <strong>DECT</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                    <form method='POST'>
                        <div class='container'>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <input class="form-control" value="<?= date('H:i:s'); ?>" type="text" name='hour_DECT__inter' readonly>
                                            <label for="floatingInput">Heure</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <?php
                                            $month = getdate()['mon'];
                                            $day = getdate()['mday'];

                                            if($month < 10) {
                                                $month = '0' . getdate()['mon'];
                                            }

                                            if($day < 10) {
                                                $day = '0' . getdate()['mday'];
                                            }
                                        ?>

                                        <div class="form-floating">
                                            <input class="form-control" value="<?= getdate()['year'] . '-' . $month . '-' . $day; ?>" type="text" name='date_DECT__inter' readonly>
                                            <label for="floatingInput">Date</label>
                                        </div>
                                    </div>
                                    <div class='p-2'></div>                           
                                    <div class="col-12">
                                        <?php $dect_Failures = DectController::getInstance('')->getEveryDectFailures(); ?>
                                        <div class="form-floating">
                                            <select class="form-select" name='failure_DECT__inter' >
                                                <?php foreach($dect_Failures as $key => $val) { ?>
                                                    <option value='<?=$val->getID();?>'><?= $val->getType(); ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="floatingInput">Type de panne</label>
                                        </div>
                                    </div>
                                    <div class='p-2'></div>
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <input type="text" style='text-transform: uppercase;' class="form-control" name='newnumserie_DECT__inter' id="newnumserie_DECT__inter">
                                            <label for="floatingInput" required>Nouveau N° Série</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <?php $dect_Models = DectController::getInstance('')->getEveryDectModels(); ?>
                                        <div class="form-floating">
                                            <select class="form-select" name='newtype_DECT__inter' >
                                                <?php foreach($dect_Models as $key => $val) { ?>
                                                    <option value='<?=$val->getID();?>'><?= $val->getModele(); ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="floatingInput">Nouveau modèle</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <a href='<?= DectController::getInstance('')->isSearching($dect->getEmbauche()) . '&numserie=' . $dect->getNumSerie(); ?>' class="btn btn-outline-secondary">Retour</a>
                            <button type='submit' class='btn btn-primary'>Confirmer l'intervention</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Closing the 'main' and 'div' balise from dect/sidebar.php -->
</div>
</main>
