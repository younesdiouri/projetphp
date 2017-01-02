<?php

session_start();

require "conf.inc.php";

if ($_SERVER["REQUEST_METHOD"]=="POST" &&
   !empty($_POST['email']) &&
   !empty($_POST['pwd1']) &&
   !empty($_POST['pwd2']) &&
   !empty($_POST['birthday']) &&
   !empty($_POST['captcha']) &&
   
   isset($_POST["gender"]) &&
   isset($_POST["firstname"]) &&
   isset($_POST["lastname"]) &&
   (count($_POST)==9 || count($_POST)==10)) 
{
    
    /*
        gender :  not required and radio
        firstname : not required but min 2 characters
        lastname : not required but min 2 charactersi
        country : required and select - 5pays
        birthday : required, date and min 10 years and max 110 years
        avatar : required, file, max 10mo and create id not exist "upload" directory
        legacy : (cgu) required checkbox
 
    */
    $gender = trim($_POST['gender']);
    $firstname = trim($_POST['firstname']);
    $lastname= trim($_POST['lastname']);
    $birthday = trim($_POST['birthday']);
    $email = trim($_POST['email']);
    $pwd1 = $_POST['pwd1'];
    $pwd2 = $_POST['pwd2'];
    $country = $_POST['country'];
    $legacy=$_POST['legacy'];

	$error = false;
	$listOfErrors = [];
    
    if(!isset($listOfGenders[$gender])){
        $error = true;
        $listOfErrors[]=8;
    }
	//Vérification email
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		//echo "Email non valide";
		$listOfErrors[]=1;
		$error = true;
	}

	//Vérification mpd
	if(strlen($pwd1)<8||strlen($pwd1)>16){
		//echo "Le mot de passe doit faire entre 8 et 16 caractères";
		$listOfErrors[]=2;
		$error = true;
	}

	//Vérification confirmation
	if($pwd1 != $pwd2){
		//echo "Le mot de passe de confirmation ne correspond pas";
		$listOfErrors[]=3;
		$error = true;
	}
    
    //prenom > 2 carac
    if(strlen($firstname)==1)
    {
        $listOfErrors[]=4;
        $error = true;         
    }
    
    //nom > 2 carac
    if(strlen($lastname)==1)
    {
            $listOfErrors[]=5;
            $error = true;
    }
    //pays
    if(!isset($listOfCountries[$country]) ){
        $listOfErrors[]=9;
        $error=true;
    }
    
    //2016-12-13
    //13/12/2016
    $pattern=(strpos($birthday,"-"))?"Y-m-d":"d/m/Y";
    // On convertit birthday en objet datetime avec un pattern spécifique si c'est fr ou en
    $dateBirthday = DateTime::createFromFormat($pattern, $birthday);
    
    // on récupère les erreurs dateTime si l'utilisateur entre de la merde
    $dateErrors = DateTime::getLastErrors();
    if($dateErrors["warning_count"]+$dateErrors["error_count"]==0) 
    {
        $dateToday = new dateTime();
        $age = $dateBirthday->diff($dateToday)->format("%y");
        if($age<10 || $age>110) 
        {
            $listOfErrors[]=7;
            $error=true;
        }
    }
    else{
        $listOfErrors[10];
        $error = true;
    }
    
    //legacy
    if (!isset($legacy)) 
    {
        $listOfErrors[]=11;
        $error=true;
    }
    
    //captcha
    if ($_POST['captcha'] != $_SESSION["captcha"]) 
    {
        $error=true;
        $listOfErrors[]=14;
    }
    
    //AVATAR
    if($_FILES["avatar"]["error"]==0)
    {
        
        $infoAvatar = pathinfo($_FILES["avatar"]["name"]);
        if (!in_array(strtolower($infoAvatar["extension"]),$avatarExtensionAuthorized)) 
        {
            $error=true;
            $listOfErrors["13"];
        }
        if($_FILES["avatar"]["size"]>$avatarMaxSize){   
            $error=true;
            $listOfErrors[]=13;
        }
    }
    else
    {
        $error=true;
        switch ($_FILES["avatar"]["error"]) { 
            case UPLOAD_ERR_INI_SIZE: 
                $listOfErrors[]=15;
                break; 
            case UPLOAD_ERR_FORM_SIZE: 
                 $listOfErrors[]=15;
                break; 
            case UPLOAD_ERR_PARTIAL: 
                 $listOfErrors[]=15;
                break; 
            case UPLOAD_ERR_NO_FILE: 
                 $listOfErrors[]=15;
                break; 
            case UPLOAD_ERR_NO_TMP_DIR: 
                 $listOfErrors[]=15;
                break; 
            case UPLOAD_ERR_CANT_WRITE: 
                 $listOfErrors[]=15; 
                break; 
            case UPLOAD_ERR_EXTENSION: 
                $listOfErrors[]=15;
                break; 

            default: 
                 $listOfErrors[]=15;
                break; 
        } 
    }
    
      if(!$error){
        $uploadPath = __DIR__.DS."upload";
        if( !file_exists($uploadPath) ){
            mkdir($uploadPath);
        }
        $nameAvatar = uniqid().".".strtolower($infoAvatar["extension"]);
        if(!move_uploaded_file($_FILES["avatar"]["tmp_name"], $uploadPath.DS.$nameAvatar)){
            $listOfErrors[]=14;
            $error = true;
        }else{
 
         //Inscription en BDD
                try{
                    $pdo= new PDO("mysql:host=". HOST .";port=". DBPORT .";dbname=". DATABASE .";" , USERDB , USERPWD);
                   
                }catch(Exception $e){
                    die("Erreur SQL".$e->getMessage());
                }
               $mailQuery = $pdo->prepare("SELECT count(*) AS mailexist from users where email = :email");
                $mailQuery->execute(["email"=>$email]);
                $result = $mailQuery->fetch(PDO::FETCH_ASSOC);
              
                if ($result["mailexist"]==1){
                    $error= true;
                    $listOfError[]=17;
                }
                else{
                //On prépare une requete
                $query = $pdo->prepare("INSERT INTO users (gender, lastname, firstname, country, birthday, email, password, avatar) 
                VALUES (:gender, :lastname, :firstname, :country, :birthday, :email, :password, :avatar)");
                //On exécute la requête
                $query->execute([
                    "gender"=>$gender,
                    "lastname"=>$lastname,
                    "firstname"=>$firstname,
                    "country"=>$country,
                    "birthday"=>$dateBirthday->format('Y-m-d'),
                    "email"=>$email,
                    "password"=>$pwd1,
                    "avatar"=>$nameAvatar
                    //8
                ]);
            
                }
                
                //Se connecter à la BDD
                
                //On prépare une requete
           
        }
 
    }

    
    if ($error) 
    {
        $_SESSION["error_form"] = $listOfErrors;
        $_SESSION["value_form"] = $_POST;
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
}

//First If condition out
die();

	






	
?>