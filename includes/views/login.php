<?php
    echo $this->header;
?>
<div class="main">
    <div class="login">
        <form class="form-signin">
            <h1 class="h3 mb-3 font-weight-normal">Login</h1>
            <label class="sr-only" for="email" >E-Mail Adresse</label>
            <input class="form-control" type="email" id="email"  placeholder="E-Mail Adresse" required autofocus>
            <label class="sr-only" for="password">Passwort</label>
            <input class="form-control" type="password" id="password" placeholder="Passwort" required>
            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Angemeldet bleiben
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
            <a href="<?php echo URL_PATH; ?>/register" class="btn btn-lg btn-secondary btn-block" id="register">Register</a>
        </form>
    </div>
</div>
<?php
    echo $this->footer;
?>