<?php
    echo $this->header;
?>
<div class="main register">
    <div class="container">
        <form class="form-signup">
            <div class="row mb-1">
                <h1 class="h2 font-weight-normal text-center">Registrierung</h1>
            </div>
            <div class="row mb-3">
                <p class="m-0">Erstellen Sie jetzt einen kostenlosen Account.</p>
            </div>
            <div class="row mb-1">
                <label class="sr-only" for="salutation">Anrede</label>
                <!--<input class="form-control" type="text" id="salutation" placeholder="Anrede" required autofocus>-->
            </div>
            <div class="row mb-1">
                <label class="sr-only" for="firstname">Vorname</label>
                <input class="form-control" type="text" id="firstname" placeholder="Vorname" required autofocus>
            </div>
            <div class="row mb-1">
                <label class="sr-only" for="lastname">Nachname</label>
                <input class="form-control" type="text" id="lastname" placeholder="Nachname" required autofocus>
            </div>
            <div class="row mb-1">
                <label class="sr-only" for="email" >E-Mail Adresse</label>
                <input class="form-control" type="email" id="email" placeholder="E-Mail Adresse" required autofocus>
            </div>
            <input class="form-control" type="password" id="password" placeholder="Passwort">
            <input class="form-control" type="password" id="passwordRepeated" placeholder="Password bestätigen">
            <button class="btn btn-lg btn-primary btn-block" id="registerBtn" name="signup"> Abschicken</button>
        </form>
    </div>
</div>