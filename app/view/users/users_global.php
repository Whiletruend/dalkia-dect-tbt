<div class="col overflow-auto h-100">
    <div class="bg-light border rounded-3 p-3">
        <h2>Vue d'ensemble des utilisateurs</h2>
        <p>Voici une vue d'ensemble de tous vos utilisateurs, vous pouvez effectuer des recherches, des ajouts, des modifications ou bien des suppresions.</p>
        <?php if($this->msg_type != '') {?>
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
                            <td><a href='./?action=users_global&emb=<?= $val->getEmbauche(); ?>' class='btn btn-outline-info'><i class='fa fa-info-circle'></i></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Users infos modal -->
<div class="modal fade" id="users_INFOS_btn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Informations de l'utilisateur <strong>NOM PRENOM</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        ...
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