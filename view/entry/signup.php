<?php $pageTitle = "Site CFDT INTERCO77"; $wrapper = 'class="container"'; ?>

<section class="container">

    <h2 class="sectionTitle">Inscription</h2>

    <div class="shapeForm">
        <form method="post" action="<?= HOST.'signup' ?>" class="paddingRule">
            <div class="form-group">
                <label for="login">Identifiant <span class="textRed font-weight-bold" title="Requis">*</span> <div class="d-inline-block" id="resultLogin"></div></label>
                <input type="text" class="form-control" name="login" id="login" value="<?= isset($_SESSION['yourLogin']) ? $_SESSION['yourLogin'] : '' ?>" required="true" />
            </div>
            <div class="form-group">
                <label for="email">Email <span class="textRed font-weight-bold" title="Requis">*</span> <div class="d-inline-block" id="resultEmail"></div></label>
                <input type="text" class="form-control" name="email" id="email" value="<?= isset($_SESSION['yourEmail']) ? $_SESSION['yourEmail'] : '' ?>" required="true" />
            </div>
            <div class="form-group">
                <label for="password">Mot de passe <span class="textRed font-weight-bold" title="Requis">*</span> <div class="d-inline-block" id="resultPassword"></div></label>
                <input type="password" class="form-control" name="password" id="password" required="true" />                
            </div>
            <div class="securityLevel">
                <div class="strengh"></div>
                <div class="separators" style="left: 20%"></div>
                <div class="separators" style="left: 40%"></div>
                <div class="separators" style="left: 60%"></div>
                <div class="separators" style="left: 80%"></div>
            </div>
            <div class="form-group">
                <label for="matchPassword">Confirmez votre mot de passe <span class="textRed font-weight-bold" title="Requis">*</span> <div class="d-inline-block" id="resultMatchPassword"></div></label>
                <input type="password" class="form-control" name="matchPassword" id="matchPassword" required="true" />
            </div>            
            <div class="form-group">
                 <input type="checkbox" name="employee" id="employee" /> <label for="employee">Je suis salarié(e) à la mairie de Moissy-Cramayel</label>
            </div>
            <div id="userName" class="form-group">
                <label for="name">Prénom <span class="textRed font-weight-bold" title="Requis"></span></label>
                <input type="text" class="form-control" name="name" id="name" value="<?= isset($_SESSION['yourName']) ? $_SESSION['yourName'] : '' ?>" />
            </div>
            <div id="userLastname" class="form-group">
                <label for="lastname">Nom <span class="textRed font-weight-bold" title="Requis"></span></label>
                <input type="text" class="form-control" name="lastname" id="lastname" value="<?= isset($_SESSION['yourLastname']) ? $_SESSION['yourLastname'] : '' ?>" />
            </div>
            <div id="userMatricule" class="form-group">
                <label for="matricule">Matricule <span class="textRed font-weight-bold" title="Requis"></span><div class="d-inline-block" id="resultMatricule"></div></label>
                <input type="text" class="form-control" name="matricule" id="matricule" value="<?= isset($_SESSION['yourMatricule']) ? $_SESSION['yourMatricule'] : '' ?>"  />
            </div>
            <div class="form-group">
                 <input type="checkbox" name="termOfService" required="true" id="termOfService" /> <label for="termOfService"> J'accepte les <a id="service" href="<?= HOST.'TermOfService.html' ?>">conditions d'utilisation <span class="textRed font-weight-bold" title="Requis">*</span></a></label>
            </div>
            
            <input class="button" type="submit" id="signupSubmit" value="S'inscrire" />

        </form>
        <p class=" paddingRule"><span class="textRed font-weight-bold" title="Requis">*</span> : champs requis</p>
    </div>
</section>
