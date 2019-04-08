<?php
    echo $this->header;
?>
<div class="main login">
    <div class="container">
        <form class="form-signin">
            <div class="row mb-2">
                <h1 class="h3 d-block font-weight-normal text-center w-100">Filemanager</h1>
            </div>
            <div class="row mb-1">
                <label class="sr-only" for="email" >E-Mail Adresse</label>
                <input class="form-control" type="email" id="email" placeholder="E-Mail Adresse" required autofocus>
            </div>
            <div class="row mb-2">
                <label class="sr-only" for="password">Passwort</label>
                <input class="form-control" type="password" id="password" placeholder="Passwort" required>
            </div>
            <div class="row mb-2 justify-content-center">
                <label>
                    <input type="checkbox" value="remember-me"> Angemeldet bleiben
                </label>
            </div>
            <div class="row mb-2">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
            </div>
            <div class="row">
                <a href="<?php echo URL_PATH; ?>/register" class="btn btn-lg btn-secondary btn-block" id="register">Register</a>
            </div>
        </form>
    </div>
</div>
<?php
    echo $this->footer;
?>