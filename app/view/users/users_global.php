<div class="col overflow-auto h-100">
    <div class="bg-light border rounded-3 p-3">
        <h2>Vue d'ensemble des utilisateurs</h2>
        <p>Voici une vue d'ensemble de tous vos utilisateurs, vous pouvez effectuer des recherches, des ajouts, des modifications ou bien des suppresions.</p>
        <?php

use App\controller\UserController;
use App\model\User;

if($this->msg_type != '') {?>
            <div class='p-2'></div>
            <div class="alert alert-<?= $this->msg_type; ?> alert-dismissible fade show" id='users_SEARCH_alert' role="alert">
                <strong>Erreur !</strong> <?= $this->msg_text; ?>
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
    </div>
</div>

<?php if(isset($_GET['emb'])) { ?>
    <script type="text/javascript">
        $(window).on('load', function() {
            $('#usersInfos_modal').modal('show');
        });
    </script>
<?php } ?>

<!-- Users infos modal -->
<div class="modal fade" tabindex="-1" id='usersInfos_modal' aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Informations sur <strong><?= $this->usersList[$_GET['emb']]->getNom(); ?></strong> <strong><?= $this->usersList[$_GET['emb']]->getPrenom(); ?></strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class='container'>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating">
                                <input class="form-control" value="<?= $val->getNom(); ?>" type="text" name='recap_name_BUSINESS' readonly>
                                <label for="floatingInput">Nom de l'utilisateur</label>
                            </div>
                        </div>
                    </div>
                    <div class='p-2'></div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating">
                                <input class="form-control" value="<?= $val->getPrenom(); ?>" type="text" name='recap_name_BUSINESS' readonly>
                                <label for="floatingInput">Prénom de l'utilisateur</label>
                            </div>
                        </div>
                    </div>
                    <div class='p-2'></div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating">
                                <input class="form-control" value="<?= $val->getEmbauche(); ?>" type="text" name='recap_name_BUSINESS' readonly>
                                <label for="floatingInput">Embauche de l'utilisateur</label>
                            </div>
                        </div>
                    </div>
                    <div class='p-2'></div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating">
                                <input class="form-control" value="<?= $val->getCA(); ?>" type="text" name='recap_name_BUSINESS' readonly>
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

                    <h6>DECT Possédé(s):</h6>
                    <div class="list-group overflow-auto">
                        <?php 
                            $dectList = UserController::getInstance('')->getDectByEmbauche($_GET['emb']);
                            
                            foreach($dectList as $key => $val) {
                                echo '<a href="#" class="list-group-item list-group-item-action">' . $val->getAppel() . '</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Modifier</button>
                <button type="button" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>
</div>


<!-- Closing the 'main' and 'div' balise from users/sidebar.php -->
</div>
</main>