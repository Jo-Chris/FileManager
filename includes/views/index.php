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
                    <a class="nav-link dropdown-toggle" href="#" id="new" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-plus fa-sm"></i> Neu</a>
                    <div class="dropdown-menu" aria-labelledby="new">
                        <a class="dropdown-item" href="#">Ordner</a>
                        <a class="dropdown-item" href="#">Datei</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="upload" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-cloud-upload-alt"></i> Upload</a>
                    <div class="dropdown-menu" aria-labelledby="upload">
                        <a class="dropdown-item" href="#">Ordner</a>
                        <a class="dropdown-item" href="#">Datei</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-md-0 mr-auto">
                <input class="form-control" type="text" name="keyword" placeholder="Suchen nach...">
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
                        <a class="dropdown-item" href="#">Mein Konto</a>
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
            <div class="h-100" id="tree-container"></div>
        </div>
        <div class="col-8 maincolumn h-100">
            <div class="h-100 p-3 pl-4">
                <!-- change to blue --> 
                <table class="table" id="main-list">
                    <thead>
                        <th scope="col"></th>
                        <th scope="col">Dateinname</th>
                        <th scope="col">Größe</th>
                        <th scope="col">Zuletzt bearbeitet</th>
                    </thead>
                    <tbody id="tbody-table">     
                        <!-- Dynamic Content follows here -->
                    </tbody>                
                
                </table>
            </div>
        </div>
    </div>
</main>
<?php
    echo $this->footer;
?>