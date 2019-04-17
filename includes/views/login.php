<?php
    echo $this->header;
?>
<main class="main login">
    <div class="container m-auto">
        <form class="form-signin mb-3 mt-3" action="login" method="post">
            <div class="row mb-3 ml-0 mr-0">
                <h1 class="h2 font-weight-normal mb-0 text-center w-100">Filemanager</h1>
            </div>
            <div class="row mb-2 ml-0 mr-0">
                <label class="sr-only" for="email" >E-Mail Adresse</label>
                <input class="form-control" type="email" id="email" placeholder="E-Mail Adresse" required autofocus>
            </div>
            <div class="row mb-3 ml-0 mr-0">
                <label class="sr-only" for="password">Passwort</label>
                <input class="form-control" type="password" id="password" placeholder="Passwort" required>
            </div>
            <div class="row mb-3 ml-0 mr-0 justify-content-center">
                <label class="mb-0">
                    <input type="checkbox" value="remember-me"> Angemeldet bleiben
                </label>
            </div>
            <div>
                <button class="btn btn-lg btn-primary btn-block font-weight-bold text-uppercase" type="submit" name="action">Login</button>
                <a href="<?php echo URL_PATH; ?>/register" class="btn btn-lg btn btn-outline-primary btn-block font-weight-bold text-uppercase" id="register">Register</a>
            </div>
        </form>
    </div>
</main>
<?php
    echo $this->footer;
?>