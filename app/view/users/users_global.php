<div class="col overflow-auto h-100">
    <div class="bg-light border rounded-3 p-3">
        <h2>Vue d'ensemble des utilisateurs</h2>
        <p>Voici une vue d'ensemble de tous vos utilisateurs, vous pouvez effectuer des recherches, des ajouts, des modifications ou bien des suppresions.</p>
        <?php
            use App\controller\UserController;

            if($this->msg_type != '') {
        ?>
                <div class='p-2'></div>
                <div class="alert alert-<?= $this->msg_type; ?> alert-dismissible fade show" id='users_SEARCH_alert' role="alert">
                    <strong>Message !</strong> <?= $this->msg_text; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <script>
                    $("#users_SEARCH_alert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#users_SEARCH_alert").slideUp(500);
                        window.location.replace("./?action=users_global");
                    });
                </script>
            <?php } ?>
        <div class='p-2'></div> 
        
        <!-- Search bar -->
        <div>
            <form method='POST'>
                <div class="input-group mb-3">
                    <input type="text" name='users_SEARCH' class="form-control" placeholder="Recherchez un utilisateur grâce à son nom ou son n° embauche" aria-label="Recherchez un utilisateur grâce à son nom ou son n° embauche">
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
                    <th scope='col'>Nom</th>
                    <th scope='col'>Prénom</th>
                    <th scope='col'>N° Embauche</th>
                    <th scope='col'>CA</th>
                    <th scope='col'></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0; ?>
                    <?php foreach($this->usersList as $key => $val) { ?>
                        <?php $count = $count + 1; ?>
                        <tr>
                            <th scope='row'><?= $count ?></th>
                            <td> <?= $val->getNom(); ?> </td>
                            <td> <?= $val->getPrenom(); ?> </td>
                            <td> <?= $val->getEmbauche(); ?> </td>
                            <td> <?= $val->getCA(); ?> <div class='px-2'></td>

                            <!-- Button that make the informations modal popup -->
                            <td><a href='<?= UserController::getInstance('')->isSearching($val->getEmbauche()); ?>' class='btn btn-outline-info'><i class='fa fa-info-circle'></i></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <!-- REDIRECTION BASED ON URL PARAMETERS -->
        <?php if(isset($_GET['emb'])) { ?>
            <?php if(!isset($_GET['users_modifications'])) { ?>
                <?php if(!isset($_GET['users_confirmDelete'])) { ?>
                    <script type="text/javascript">
                        $(window).on('load', function() {
                            $('#usersInfos_modal').modal('show');
                        });
                    </script>
                <?php } ?>
            <?php } ?>
        <?php } ?>

        <?php if(isset($_GET['users_modifications'])) { ?>
            <script type="text/javascript">
                $(window).on('load', function() {
                    $('#usersModifs_modal').modal('show');
                });
            </script>
        <?php } ?>
        
        <?php if(isset($_GET['users_confirmDelete'])) { ?>
            <script type="text/javascript">
                $(window).on('load', function() {
                    $('#usersCheckDelete_modal').modal('show');
                });
            </script>
        <?php } ?> 
    

        <!-- Users infos modal -->
        <div class="modal fade" tabindex="-1" id='usersInfos_modal' aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- Le PHP fait bug l'affichage du Footer. A régler !! -->
                        <h5 class="modal-title" id="exampleModalLabel">Informations sur <strong><?= "l'utilisateur"; //$this->usersList[$_GET['emb']]->getNom(); ?></strong> <strong><?= ''; //$this->usersList[$_GET['emb']]->getPrenom(); ?></strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <?php
                        $user = UserController::getInstance('')->getUserByEmb($_GET['emb']);
                    ?>  

                    <div class="modal-body">
                        <div class='container'>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input class="form-control" value="<?= $user->getNom(); ?>" type="text" name='recap_name_BUSINESS' readonly>
                                        <label for="floatingInput">Nom de l'utilisateur</label>
                                    </div>
                                </div>
                            </div>
                            <div class='p-2'></div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input class="form-control" value="<?= $user->getPrenom(); ?>" type="text" name='recap_name_BUSINESS' readonly>
                                        <label for="floatingInput">Prénom de l'utilisateur</label>
                                    </div>
                                </div>
                            </div>
                            <div class='p-2'></div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input class="form-control" value="<?= $user->getEmbauche(); ?>" type="text" name='recap_name_BUSINESS' readonly>
                                        <label for="floatingInput">Embauche de l'utilisateur</label>
                                    </div>
                                </div>
                            </div>
                            <div class='p-2'></div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input class="form-control" value="<?= $user->getCA(); ?>" type="text" name='recap_name_BUSINESS' readonly>
                                        <label for="floatingInput">CA de l'utilisateur</label>
                                    </div>
                                </div>
                            </div>
                            <div class='p-2'></div>
                            <style>
                                .list-group{
                                    max-height: 150px;
                                    margin-bottom: 10px;
                                    overflow:scroll;
                                    -webkit-overflow-scrolling: touch;
                                }
                            </style>

                            <?php
                                $dect_List = UserController::getInstance('')->getDectByEmbauche($_GET['emb']);
                                $dect_Count = 0;

                                foreach($dect_List as $key => $val) {
                                    $dect_Count = $dect_Count + 1;
                                }

                                if($dect_Count == 0) {
                                    echo "<h6 class='text-danger'>Cet utilisateur ne possède pas de DECT.</h6>";
                                } elseif($dect_Count > 1) {
                                    echo "<h6>DECT Possédés ($dect_Count):</h6>";
                                } else {
                                    echo "<h6>DECT Possédé:</h6>";
                                }
                            ?>

                            <div class='list-group overflow-auto'>
                                <?php 
                                    $dect_List = UserController::getInstance('')->getDectByEmbauche($_GET['emb']);

                                    foreach($dect_List as $key => $val) {
                                        echo '<a href="./?action=dect_global&searchInfos=' . $val->getAppel() . '&emb=' . $_GET['emb'] . '&numserie=' . $val->getNumSerie() . '" class="list-group-item list-group-item-action">' . $val->getAppel() . '</a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <a href="<?= UserController::getInstance('')->isSearching($user->getEmbauche()) . '&users_confirmDelete'; ?>" dismiss='modal' class='btn btn-outline-danger mr-auto'>Supprimer</a>
                        <a href="<?= UserController::getInstance('')->isSearching($user->getEmbauche()) . '&users_modifications'; ?>" class='btn btn-outline-secondary'>Modifier</a>
                        <button type='button' class='btn btn-primary'>OK</button>
                    </div>
                </div>
            </div>
        </div>


         <!-- Users infos modal -->
         <div class="modal fade" tabindex="-1" id='usersModifs_modal' aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- Le PHP fait bug l'affichage du Footer. A régler !! -->
                        <h5 class="modal-title" id="exampleModalLabel">Informations sur <strong><?= "l'utilisateur"; //$this->usersList[$_GET['emb']]->getNom(); ?></strong> <strong><?= ''; //$this->usersList[$_GET['emb']]->getPrenom(); ?></strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <?php
                        $user = UserController::getInstance('')->getUserByEmb($_GET['emb']);
                    ?>  

                    <form method='POST'>
                        <div class="modal-body">
                            <div class='container'>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input class="form-control" value="<?= $user->getNom(); ?>" type="text" name='nom_UTILISATEUR__update'>
                                            <label for="floatingInput">Nom de l'utilisateur</label>
                                        </div>
                                    </div>
                                </div>
                                <div class='p-2'></div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input class="form-control" value="<?= $user->getPrenom(); ?>" type="text" name='prenom_UTILISATEUR__update'>
                                            <label for="floatingInput">Prénom de l'utilisateur</label>
                                        </div>
                                    </div>
                                </div>
                                <div class='p-2'></div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input class="form-control" value="<?= $user->getEmbauche(); ?>" type="text" name='embauche_UTILISATEUR__update'>
                                            <label for="floatingInput">Embauche de l'utilisateur</label>
                                        </div>
                                    </div>
                                </div>
                                <div class='p-2'></div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input class="form-control" value="<?= $user->getCA(); ?>" type="text" name='ca_UTILISATEUR__update'>
                                            <label for="floatingInput">CA de l'utilisateur</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    
                        <div class="modal-footer">
                            <a href="<?= UserController::getInstance('')->isSearching($user->getEmbauche()); ?>" dismiss='modal' class='btn btn-outline-secondary'>Retour</a>
                            <button type='submit' class='btn btn-primary'>Valider les changements</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Users delete check -->
        <div class="modal fade" tabindex="-1" id='usersCheckDelete_modal' data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- Le PHP fait bug l'affichage du Footer. A régler !! -->
                        <h5 class="modal-title" id="exampleModalLabel">Êtes-vous sûr de vouloir <strong>supprimer</strong> le DECT ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class='container'>
                            <div class="row">
                                <div class="col-12">
                                    <h6>Supprimer un utilisateur est <strong>définitif</strong> et aucun retour en arrière ne sera possible !</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href='<?= UserController::getInstance('')->isSearching($user->getEmbauche()); ?>' class="btn btn-outline-secondary">Retour</a>
                        <a href='./?action=user_delete&emb=<?= $user->getEmbauche(); ?>' class="btn btn-danger">J'en suis sûr</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Closing the 'main' and 'div' balise from users/sidebar.php -->
</div>
</main>
