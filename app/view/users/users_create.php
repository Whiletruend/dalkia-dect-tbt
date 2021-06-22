<div class="col overflow-auto h-100">
    <div class="bg-light border rounded-3 p-3">
        <h2>Création d'un utilisateur</h2>
        <p>Choisissez de créer un nouvel utilisateur de manière intuitive.</p>
        <div class='p-2'></div>
            <!-- idk for now -->
            <div class="bg-white border rounded-3 p-3">
                <div>
                    <form class='row g-3' method='POST'>
                        <!-- Nom & Prénom de l'utilisateur -->
                        <div class="col-md-6">
                            <label for="nom_UTILISATEUR" class="form-label">Nom</label>
                            <input type="text" style='text-transform: uppercase;' class="form-control" name='nom_UTILISATEUR__add' id="nom_UTILISATEUR__add" required>
                        </div>
                        <div class="col-md-6">
                            <label for="prenom_UTILISATEUR" class="form-label">Prénom</label>
                            <input type="text" style='text-transform: capitalize;' class="form-control" name='prenom_UTILISATEUR__add' id="prenom_UTILISATEUR__add" required>
                        </div>
                        
                        <!-- Numéro d'embauche et le CA -->
                        <div class="col-md-6">
                            <label for="embauche_UTILISATEUR" class="form-label">N° Embauche</label>
                            <input type="text" style='text-transform: uppercase;' class="form-control" name='embauche_UTILISATEUR__add' id="embauche_UTILISATEUR__add" required>
                        </div>
                        <div class="col-md-6" required>
                            <label for="ca_UTILISATEUR" class="form-label">CA</label>
                            <input type="text" style='text-transform: uppercase;' class="form-control" name='ca_UTILISATEUR__add' id="ca_UTILISATEUR__add" required>
                        </div>

                        <div class='col-md-12'>
                            <!-- Retry button -->
                            <a href='./?action=users_create'><button type='button' class="btn btn-secondary">Recommencer</button></a>

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