<?php
    echo $this->header;
?>
<main class="main login">
    <div class="container m-auto">
        <form class="form-signin mb-3 mt-3" action="login" method="post">
            <input type="hidden" name="action" value="login">
            <div class="row mb-3 ml-0 mr-0">
                <h1 class="h2 font-weight-normal mb-0 text-center w-100">Filemanager</h1>
            </div>
            <div class="row mb-2 ml-0 mr-0">
                <label class="sr-only" for="email" >E-Mail Adresse</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="E-Mail Adresse" required autofocus>
            </div>
            <div class="row mb-3 ml-0 mr-0">
                <label class="sr-only" for="password">Passwort</label>
                <input class="form-control" type="password" name="password" id="password" placeholder="Passwort" required>
            </div>
            <?php if ($this->errorPasswd == true): ?>
                <div class="alert alert-danger pb-2 pl-3 pr-3 pt-1" role="alert">Benutzername und/oder Passwort sind falsch!</div>
            <?php endif; ?>
            <div class="row mb-3 ml-0 mr-0 justify-content-center">
                <label class="mb-0">
                    <input type="checkbox" value="remember-me"> Angemeldet bleiben
                </label>
            </div>
            <div>
                <button class="btn btn-lg btn-primary btn-block font-weight-bold text-uppercase" type="submit">Login</button>
                <a href="<?php echo URL_PATH; ?>/register" class="btn btn-lg btn btn-outline-primary btn-block font-weight-bold text-uppercase" id="register">Register</a>
            </div>
        </form>
    </div>
</main>
<?php
    echo $this->footer;
?>