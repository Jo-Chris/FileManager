<?php
    echo $this->header;
?>
<div class="main">
    <div class="register">
        <form class="form-signup">
            <h1 class="h2 mb-3 font-weight-normal"> Register now</h1>
            <p> Erstelle jetzt einen Account. Kostenlos & unverbindlich!</p>
            <input class="form-control" type="text" id="fname" placeholder="Vorname">
            <input class="form-control" type="text" id="lname" placeholder="Nachname">
            <input class="form-control" type="email" id="email" placeholder="E-Mail Adresse">
            <input class="form-control" type="password" id="password" placeholder="Passwort">
            <input class="form-control" type="password" id="passwordRepeated" placeholder="Password bestätigen">
            <button class="btn btn-lg btn-primary btn-block" id="registerBtn" name="signup"> Abschicken</button>
        </form>
    </div>
</div>