<?php $pageTitle = "Site CFDT INTERCO77"; ?>

<section class="container formulaire">
    <div class="row col-md-6" id="shapeForm">
        <form method="post" action="<?= HOST.'signup' ?>" class="col-md-12">
            <div class="form-group">
                <label for="name">Prénom</label>
                <input type="text" class="form-control" name="name" value="<?= isset($_SESSION['yourName']) ? $_SESSION['yourName'] : '' ?>" required="true" />
            </div>
            <div class="form-group">
                <label for="lastname">Nom</label>
                <input type="text" class="form-control" name="lastname" value="<?= isset($_SESSION['yourLastname']) ? $_SESSION['yourLastname'] : '' ?>" required="true" />
            </div>
            <div class="form-group">
                <label for="nickname">Pseudo</label>
                <input type="text" class="form-control" name="login" value="<?= isset($_SESSION['yourLogin']) ? $_SESSION['yourLogin'] : '' ?>" required="true" />
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="text" class="form-control" name="email" value="<?= isset($_SESSION['yourEmail']) ? $_SESSION['yourEmail'] : '' ?>" required="true" />
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" name="password" required="true" />
            </div>
            <div class="form-group">
                <label for="matchPassword">Confirmez votre mot de passe</label>
                <input type="password" class="form-control" name="matchPassword" required="true" />
            </div>
            <div class="form-group">
                 <input type="checkbox" name="termOfService" required="true" id="termOfService" /> <label for="termOfService"> J'accepte les <a href="#">conditions d'utilisation</a></label>
            </div>
            <div class="form-group">
                <input class="buttons" type="submit" value="S'inscrire" />
            </div>
        </form>
    </div>
</section>
