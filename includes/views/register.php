<?php
    echo $this->header;
?>
<main class="main register">
    <div class="container m-auto">
        <form class="form-signup mb-3 mt-3" action="register" method="post">
            <input type="hidden" name="action" value="register">
            <div class="mb-0">
                <h1 class="h2 font-weight-normal mb-0 text-center w-100">Registrierung</h1>
            </div>
            <div class="mb-3">
                <p class="m-0 text-center">Erstellen Sie jetzt kostenlos Ihr Konto.</p>
            </div>
            <div class="row form-group mb-1 ml-0 mr-0">
                <label class="mb-1" for="gender">Anrede</label>
                <select class="form-control" name="gender" id="gender">
                    <option value="">Bitte wählen...</option>
                    <option value="m">Herr</option>
                    <option value="f">Frau</option>
                </select>
            </div>
            <div class="row">
                <div class="col-sm form-group row mb-1 ml-0 mr-0">
                    <label class="mb-1" for="firstname">Vorname</label>
                    <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Vorname" required>
                </div>
                <div class="col-sm form-group row mb-1 ml-0 mr-0">
                    <label class="mb-1" for="lastname">Nachname</label>
                    <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Nachname" required>
                </div>
            </div>
            <div class="row form-group row mb-1 ml-0 mr-0">
                <label class="mb-1" for="email">E-Mail Adresse</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="E-Mail Adresse" required>
            </div>
            <div class="row">
                <div class="col-sm form-group row mb-1 ml-0 mr-0">
                    <label class="mb-1" for="password">Passwort</label>
                    <input class="form-control" type="password" name="password" id="password" placeholder="Passwort" required>
                </div>
                <div class="col-sm form-group row mb-1 ml-0 mr-0">
                    <label class="mb-1" for="lastname">Passwort bestätigen</label>
                    <input class="form-control" type="password" name="passwordconfirmation" id="passwordconfirmation" placeholder="Passwort bestätigen" required>
                </div>
            </div>
            <?php if ($this->errorMsg != "" ): ?>
                <div class="alert alert-danger pb-2 pl-3 pr-3 pt-1 mb-3 mt-2" role="alert"><?php echo $this->errorMsg; ?></div>
            <?php endif; ?>
            <div class="mt-3">
                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" id="registerBtn">Jetzt registrieren</button>
            </div>
        </form>
    </div>
</main>