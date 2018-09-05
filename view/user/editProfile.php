<?php $pageTitle = "Site CFDT INTERCO77"; $wrapper = 'class="container"'; ?>

<section class="container">

    <h2 class="sectionTitle">Modification du profil</h2>

    <div class="shapeForm">
        <form method="post" action="<?= HOST.'updateProfile' ?>" class="paddingRule">
            <input type="hidden" name="id" value="<?= $user->id() ?>" >
            <div class="form-group">
                <label for="login">Identifiant <span class="textRed font-weight-bold" title="Requis">*</span><div class="d-inline-block" id="resultLogin"></div></label>
                <input type="text" class="form-control" name="login" id="login" value="<?= $user->login() ?>" <?= ($_SESSION['rank'] < 5) ? 'disabled' : '' ?> required="true" />
            </div>
            
            <?php if(($user->seeEmail() <= $_SESSION['rank'] AND $user->seeEmail() != 0) OR $user->id() === $_SESSION['id']) :?>
                <div class="form-group">
                    <label for="email">Email <span class="textRed font-weight-bold" title="Requis">*</span><div class="d-inline-block" id="resultEmail"></div></label>
                    <input type="text" class="form-control" name="email" id="email" value="<?= $user->email() ?>" required="true" />
                </div>
            <?php endif ?>

            <?php if(($user->seePhoneNumber() <= $_SESSION['rank'] AND $user->seePhoneNumber() != 0) OR $user->id() === $_SESSION['id']) :?>
                <div class="form-group">
                    <label for="phoneNumber">Téléphone</label>
                    <input type="text" class="form-control" name="phoneNumber" placeholder="Sous la forme suivante : 0160606789" value="<?= $user->phoneNumber() ?>" />
                </div>
            <?php endif ?>

            <div class="form-group">
                <label for="oldPassword">Mot de passe</label>
                <input type="password" class="form-control" name="oldPassword" id="oldPassword" />
            </div>
            <div class="form-group">
                <label for="password">Nouveau mot de passe<div class="d-inline-block" id="resultPassword"></div></label>
                <input type="password" class="form-control" name="password" id="password" />
            </div>
            <div class="securityLevel">
                <div class="strengh"></div>
                <div class="separators" style="left: 20%"></div>
                <div class="separators" style="left: 40%"></div>
                <div class="separators" style="left: 60%"></div>
                <div class="separators" style="left: 80%"></div>
            </div>
            <div class="form-group">
                <label for="matchPassword">Confirmez votre nouveau mot de passe<div class="d-inline-block" id="resultMatchPassword"></div></label>
                <input type="password" class="form-control" name="matchPassword" id="matchPassword" />
            </div>
            <?php if($user->id() === $_SESSION['id']) :?>
                <div class="form-group">
                     <input type="checkbox" name="employee" id="employee" <?= ($user->employee())? 'checked' : '' ?> /> <label for="employee">Je suis salarié(e) à la mairie de Moissy-Cramayel</label>
                </div>
            <?php endif ?>

            <?php if(($user->seeName() <= $_SESSION['rank'] AND $user->seeName() != 0) OR $user->id() === $_SESSION['id']) :?>
                <div id="userName" class="form-group">
                    <label for="name">Prénom <span class="textRed font-weight-bold" title="Requis"></span></label>
                    <input type="text" class="form-control" name="name" id="name" value="<?= $user->name() ?>" />
                </div>
            <?php endif ?>

            <?php if(($user->seeLastName() <= $_SESSION['rank'] AND $user->seeLastName() != 0) OR $user->id() === $_SESSION['id']) :?>
                <div id="userLastname" class="form-group">
                    <label for="lastname">Nom <span class="textRed font-weight-bold" title="Requis"></span></label>
                    <input type="text" class="form-control" name="lastname" id="lastname" value="<?= $user->lastname() ?>" />
                </div>
            <?php endif ?>

            <?php if($user->id() === $_SESSION['id']) :?>
                <div id="userMatricule" class="form-group">
                    <label for="matricule">Matricule <span class="textRed font-weight-bold" title="Requis"></span><div class="d-inline-block" id="resultMatricule"></div></label>
                    <input type="text" class="form-control" name="matricule" id="matricule" value="<?= $user->matricule() ?>"  />
                </div>            
            <?php endif ?>

            <input class="button" type="submit" value="Enregistrer les modifications" />
            
        </form>
        <p class=" paddingRule"><span class="textRed font-weight-bold" title="Requis">*</span> : champs requis</p>
    </div>
</section>
