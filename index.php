<?php

	session_start();

	require "conf.inc.php";
	include "header.php";
/*
 
        Tous les champs doivent récupérer les info en cas d'erreur
        Code propre et commenté
 
        gender :  not required and radio
        firstname : not required but min 2 characters
        lastname : not required but min 2 characters
        country : required and select - 5pays
        birthday : required, date and min 10 years and max 110 years
        avatar : required, file, max 10mo and create id not exist "upload" directory
        legacy : (cgu) required checkbox
 
    */
?>

    <section>


        <?php
	if(isset($_SESSION["error_form"])){
		foreach ($_SESSION["error_form"] as $error) {
			echo "<li>".$listOfErrors[$error];
		}
	}
?>

            <form method="POST" action="subscribe.php" enctype="multipart/form-data">

                <!--SEXE -->
                <?php
                
                //Si gender existe dans value form = si il a déja tenté de le remplir avant ,, Alors ca sera égal à ce champ sinon ca sera defaultGender qui est Monsieur 
                
                $defaultGender = (isset($_SESSION[" value_form "]["gender"]))?$_SESSION["value_form "]["gender"]:$defaultGender;
                foreach($listOfGenders as $key => $value){
                    echo '<label><input 
                    type="radio" 
                    name="gender" 
                    value="'.$key.'" '.(( $key == $defaultGender ) ? 'checked="checked"':'').'>'.$value.' </label>';
                }
                
                ?>
                <br>

                <!-- NOM PRENOM -->
                <input type="text" name="firstname" placeholder="Prénom" value="<?php echo (isset($_SESSION[" value_form "]["firstname "]))?$_SESSION["value_form "]["firstname"]:" " ?>"><br>
                <input type="text" name="lastname" placeholder="Nom" value="<?php echo (isset($_SESSION[" value_form "]["lastname "]))?$_SESSION["value_form "]["lastname"]:" " ?>"><br>

                <!-- DATE DE NAISSANCE -->
                Date de naissance : <input type="date" name="birthday" required="required"><br>

                <!-- EMAIL -->
                <input type="email" name="email" placeholder="Votre email" required="required" value="<?php echo (isset($_SESSION[" value_form "]["email "]))?$_SESSION["value_form "]["email "]:" " ?>"><br>

                <!-- MOT DE PASSE -->
                <input type="password" name="pwd1" placeholder="Votre mot de passe" required="required"><br>
                <input type="password" name="pwd2" placeholder="Confirmation" required="required"><br>

                <!-- CGU -->
                <label>
                Conditions générales d'utilisation :<input type="checkbox" name="legacy" required="required"><br>
                </label>
                
                <!-- PAYS -->
                Pays : <select name="country">
    <?php 
        foreach($listOfCountries as $key => $value)
        {
            echo "<option value=\"".$key."\">".$value."</option>";
        }
    ?>
    </select><br> Uploader votre Avatar:
                <input type="file" name="avatar" id="fileToUpload"><br>
                <img src="captcha.php"><br>
                <input type="text" placeholder="Votre captcha" name="captcha" required="required"><br>
                
                <input type="submit" value="S'inscrire">
            </form>


    </section>

    <?php

    unset($_SESSION["value_form"]);
    unset($_SESSION["error_form"]);
           
	include "footer.php";
?>