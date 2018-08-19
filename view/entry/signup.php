<?php $pageTitle = "Site CFDT INTERCO77"; $wrapper = 'class="container"'; ?>

<section class="container">

    <h2 class="sectionTitle">Inscription</h2>

    <div id="shapeForm">
        <form method="post" action="<?= HOST.'signup' ?>" class="paddingRule">
            <div class="form-group">
                <label for="login">Identifiant (Obligatoire)</label>
                <input type="text" class="form-control" name="login" value="<?= isset($_SESSION['yourLogin']) ? $_SESSION['yourLogin'] : '' ?>" required="true" />
            </div>
            <div class="form-group">
                <label for="email">E-mail (Obligatoire)</label>
                <input type="text" class="form-control" name="email" value="<?= isset($_SESSION['yourEmail']) ? $_SESSION['yourEmail'] : '' ?>" required="true" />
            </div>
            <div class="form-group">
                <label for="password">Mot de passe (Obligatoire)</label>
                <input type="password" class="form-control" name="password" required="true" />
            </div>
            <div class="form-group">
                <label for="matchPassword">Confirmez votre mot de passe (Obligatoire)</label>
                <input type="password" class="form-control" name="matchPassword" required="true" />
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
            <div class="form-group">
                 <input type="checkbox" name="termOfService" required="true" id="termOfService" /> <label for="termOfService"> J'accepte les <a id="service" href="<?= HOST.'TermOfService.html' ?>">conditions d'utilisation (Obligatoire)</a></label>
            </div>
            
            <input class="button" type="submit" value="S'inscrire" />
            
        </form>
    </div>
</section>
