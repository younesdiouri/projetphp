<?php
session_start();
 
    /*
 
        Tous les champs doivent récupérer les info en cas d'erreur
        code : clean, with comment, optimized and factorized
 
        gender :  not required and radio
        firstname : not required but min 2 characters
        lastname : not required but min 2 characters
        country : required and select
        birthday : required, date and min 10 years and max 110 years
        avatar : required, file, max 10mo and create if not exist "upload" directory
        legacy : (cgu) required checkbox
 
    */
 
 
require "conf.inc.php";
echo "<pre>";
print_r($_POST);
print_r($_FILES["avatar"]);
echo "</pre>";
 
 
if( $_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST['email']) &&  !empty($_POST['pwd1']) &&  !empty($_POST['pwd2']) && isset($_POST['gender']) && isset($_POST['firstname']) && isset($_POST['lastname']) && !empty($_POST['country'])  && !empty($_POST['birthday']) && (count($_POST)==8 ||  count($_POST)==9) && !empty($_FILES["avatar"])){
 
 
    $email = trim($_POST['email']);
    $gender = trim($_POST['gender']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $country = trim($_POST['country']);
    $birthday = trim($_POST['birthday']);
    $pwd1 = $_POST['pwd1'];
    $pwd2 = $_POST['pwd2'];
 
 
 
 
    $error = false;
    $listOfErrors = [];
 
    //vérification du genre
    if(  !isset($listOfGenders[$gender]) ){
        $listOfErrors[]=4;
        $error = true;
    }
 
    if(  strlen($firstname) == 1 ){
        $listOfErrors[]=5;
        $error = true;
    }
    if(  strlen($lastname) == 1 ){
        $listOfErrors[]=6;
        $error = true;
    }
 
    //vérification du pays
    if(  !isset($listOfCountries[$country]) ){
        $listOfErrors[]=7;
        $error = true;
    }
 
    //2016-12-13
    //13/12/2016
    $pattern = (strpos($birthday, "-"))?"Y-m-d":"d/m/Y";
    $dateBirthday = DateTime::createFromFormat($pattern, $birthday);
    $dateErrors = DateTime::getLastErrors();
    if($dateErrors["warning_count"]+$dateErrors["error_count"]==0){
        $dateToday = new dateTime();
        $age = $dateBirthday->diff($dateToday)->format("%y");
        if($age<10 || $age>110){
            $listOfErrors[]=9;
            $error = true;
        }
    }else{
        $listOfErrors[]=8;
        $error = true;
    }
 
 
 
 
 
    //Vérification email
    if( !filter_var($email, FILTER_VALIDATE_EMAIL)  ){
        //echo "Email non valide";
        $listOfErrors[]=1;
        $error = true;
    }
 
    //Vérification mpd
    if(strlen($pwd1) < 8 || strlen($pwd1) > 16 ){
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
 
    if( !isset($_POST['legacy'])){
        $listOfErrors[]=10;
        $error = true;
    }
 
    if( $_FILES["avatar"]["error"]==0 ){
 
        $infoAvatar = pathinfo($_FILES["avatar"]["name"]);
 
        if( !in_array( strtolower($infoAvatar["extension"]), $avatarExtensionAuthorized) ){
            $listOfErrors[]=12;
            $error = true;
        }
 
        if($_FILES["avatar"]["size"]>$avatarMaxSize){
            $listOfErrors[]=13;
            $error = true;
        }
       
 
 
    }else{
        $error = true;
        switch ($_FILES["avatar"]["error"]) {
            case UPLOAD_ERR_INI_SIZE:
                $listOfErrors[]=11;
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $listOfErrors[]=11;
                break;
            case UPLOAD_ERR_PARTIAL:
                $listOfErrors[]=11;
                break;
            case UPLOAD_ERR_NO_FILE:
                $listOfErrors[]=11;
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $listOfErrors[]=11;
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $listOfErrors[]=11;
                break;
            case UPLOAD_ERR_EXTENSION:
                $listOfErrors[]=11;
                break;
            default:
                $listOfErrors[]=11;
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
 
            //Inscription en bdd
           
        }
 
    }
 
    if($error){
        $_SESSION["error_form"] = $listOfErrors;
        $_SESSION["value_form"] = $_POST;
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
 
 
 
}
 
die("ACCESS DENIED");
   
?>