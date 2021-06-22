<main class="container-fluid pb-3 p-3 flex-grow-1 d-flex flex-column flex-sm-row overflow-auto">
    <div class="row flex-grow-sm-1 flex-grow-0">
        <div class="col-sm-2 flex-grow-sm-1 flex-shrink-1 flex-grow-0 pb-sm-0 pb-3">
            <div class="bg-light border rounded-3 p-3 h-100">
                <ul class="nav nav-pills flex-sm-column flex-row mb-auto justify-content-between text-truncate">
                    <li class="nav-item">
                        <a class="nav-link px-2 text-truncate <?= $this->currentPage == 'tbt_global' ? 'active' : '' ?>" aria-current="page" href="?action=tbt_global">
                            <i class="far fa-eye fs-6"></i>
                            <span class="d-none d-sm-inline">Vue d'ensemble</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link px-2 text-truncate <?= $this->currentPage == 'tbt_loan' ? 'active' : '' ?>" aria-current="page" href="?action=tbt_loan">
                            <i class="fa fa-key fs-6"></i>
                            <span class="d-none d-sm-inline">Prêt d'une clé TBT</span>
                        </a>
                    </li>
                </ul>
            </div> 
        </div>
        
<!-- The non closing of the balise 'main' and 'div' is totally normal. --> 