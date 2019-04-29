<?php
    echo $this->header;
?>
<header class="overview">
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary position-fixed w-100 z-">
        <a class="navbar-brand" href="#">Filemanager</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav mr-5">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="new" aria-haspopup="true" aria-expanded="false"><i class="fas fa-plus fa-sm"></i> Neu</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="upload" aria-haspopup="true" aria-expanded="false"><i class="fas fa-cloud-upload-alt"></i> Upload</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-md-0 mr-auto">
                <input class="form-control" type="text" name="keyword" id="global-search" placeholder="Suchen nach...">
            </form>
            <ul class="navbar-nav">
                <!--<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="sort" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-sort-amount-down"></i> Sortieren</a>
                    <div class="dropdown-menu" aria-labelledby="sort">
                        <a class="dropdown-item" href="#"><i class="fas fa-check fa-sm text-primary"></i> Name</a>
                        <a class="dropdown-item" href="#">Geändert</a>
                        <a class="dropdown-item" href="#">Größe</a>
                        <a class="dropdown-item" href="#">Aufsteigend</a>
                        <a class="dropdown-item" href="#">Absteigend</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="grid" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-th-large fa-lg"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="grid">
                        <a class="dropdown-item" href="#"><i class="fas fa-stream fa-sm text-primary"></i> Liste</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-th-large fa-sm text-primary"></i> Kacheln</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-cog fa-lg"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="settings">
                        <a class="dropdown-item" href="#">Optionen</a>
                    </div>
                </li>-->
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="user" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-circle fa-lg"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="user">
                        <a class="dropdown-item" href="logout">Abmelden</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<main class="overview container mw-100 pb-3 pt-3 h-100">
    <div class="row h-100">
        <div class="col leftcolumn h-100">
            <div class="h-100 pb-4 pl-4 pr-4 pt-3" id="tree-container">
                
                <!-- dynamic tree structure will appear here -->
            </div>
        </div>
        <div class="col-10 maincolumn h-100" id="maincol">   <!--sorry for that-->
        
            <div class="h-100 p-3">
                <div class="input-group mb-3" id="seachbar-path-container" style="display: none;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="path-value"></span>
                    </div>
                    <input type="text" class="form-control" id="searchbar" aria-describedby="basic-addon3" placeholder="Suche...">
                </div>
                <!-- if table is empty, show our rotating logo-->

                <div class="table-responsive-lg invisible" id="main-table">
                    <table class="table table-striped mt-0 align-middle" id="main-list">
                        <thead class="">
                            <th scope="col" class="table-dark col-6 bg-primary">Dateinname</th>
                            <th scope="col" class="table-dark col-2 bg-primary">Größe</th>
                            <th scope="col" class="table-dark col-2 bg-primary ">Zuletzt bearbeitet</th>
                            <th scope="col" class="table-dark col-2 bg-primary text-right">Aktionen</th>
                        </thead>
                        <tbody id="tbody-table">     
                            <!-- Dynamic Content follows here -->
                        </tbody>
                    </table>
                </div>

                

                <div id="button-action-container" class="text-left" style="display: none;">
                    <hr style="background-size: 4px; border-top: 4px solid #ccc; border-color: #ccc;">
                    
                    <button id="select-all" class="btn btn-outline-primary"><i class="far fa-hand-pointer pr-2"></i> Alle auswählen</button>
                    <button id="de-select-all" class="btn btn-outline-primary ml-2 mr-2"><i class="fas fa-minus-circle pr-2"></i> Auswahl zurücksetzen</button>
                    <button id="reverse-selection" class="btn btn-outline-primary"><i class="fas fa-undo-alt pr-2"></i>Auswahl umkehren</button>

                    <button class="btn btn-outline-danger clear-table invisible float-right mr-2" id="down-remove-btn"><i class="fas fa-trash-alt pr-2"></i>Löschen</button>
                    <button class="btn btn-outline-secondary transfer-items invisible float-right mr-2 ml-2" id="down-transfer-btn"><i class="fas fa-random pr-2"></i>Transferieren</button>
                    <button class="btn btn-outline-primary download-items invisible float-right" id="down-download-btn"> <i class="fas fa-cloud-download-alt pr-2"></i>Herunterladen</button>
                </div>

                </div>
            </div>
        </div> 
    </div>
</main>
<?php
    echo $this->footer;
?>