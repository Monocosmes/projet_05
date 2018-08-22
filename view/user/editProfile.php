<?php $pageTitle = "Site CFDT INTERCO77"; $wrapper = 'class="container"'; ?>

<section class="container">

    <h2 class="sectionTitle">Modification du profil</h2>

    <div class="shapeForm">
        <form method="post" action="<?= HOST.'updateProfile' ?>" class="paddingRule">
            <div class="form-group">
                <label for="login">Identifiant</label>
                <input type="text" class="form-control" name="login" value="<?= $user->login() ?>" <?= ($_SESSION['rank'] < 5) ? 'disabled' : '' ?> required="true" />
            </div>
            <div class="form-group">
                <label for="email">E-mail (Obligatoire)</label>
                <input type="text" class="form-control" name="email" value="<?= $user->email() ?>" required="true" />
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" name="oldPassword" />
            </div>
            <div class="form-group">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" class="form-control" name="password" />
            </div>
            <div class="form-group">
                <label for="matchPassword">Confirmez votre nouveau mot de passe</label>
                <input type="password" class="form-control" name="matchPassword" />
            </div>            
            <div class="form-group">
                 <input type="checkbox" name="employee" id="employee" /> <label for="employee">Je suis salarié(e) à la mairie de Moissy-Cramayel</label>
            </div>
            <div id="name" class="form-group hidden">
                <label for="name">Prénom (Obligatoire)</label>
                <input type="text" class="form-control" name="name" value="<?= isset($_SESSION['yourName']) ? $_SESSION['yourName'] : '' ?>" />
            </div>
            <div id="lastname" class="form-group hidden">
                <label for="lastname">Nom (Obligatoire)</label>
                <input type="text" class="form-control" name="lastname" value="<?= isset($_SESSION['yourLastname']) ? $_SESSION['yourLastname'] : '' ?>" />
            </div>
            <div id="matricule" class="form-group hidden">
                <label for="matricule">Matricule (Obligatoire)</label>
                <input type="text" class="form-control" name="matricule" value="<?= isset($_SESSION['yourMatricule']) ? $_SESSION['yourMatricule'] : '' ?>"  />
            </div>            
            
            <input class="button" type="submit" value="Enregistrer les modifications" />
            
        </form>
    </div>
</section>
