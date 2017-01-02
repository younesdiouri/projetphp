<?php
//Local Conf. php
define("APP_URL", "http://localhost/projetphp/");
define("HOST", "localhost");
define("DS","DIRECTORY_SEPARATOR");

//DB Conf
define("DATABASE", "projetphpiw2");
define("USERDB", "root");
define("USERPWD", "");
define("DBHOST", "localhost");
define("DBPORT", "3306");

$listOfErrors = [
	1=>"L'email n'est pas valide",
	2=>"Le mot de passe doit faire entre 8 et 16 caractères",
	3=>"Le mot de passe de confirmation ne correspond pas",
    4=>"Le prenom doit faire au moins 2 caractères",
    5=>"Le nom doit faire au moins 2 caractères",
    6=>"La taille de l'avatar doit être inférieure à 10MO",
    7=>"Votre âge doit être compris entre 10 et 110 ans ",
    8=>"Le genre n'existe pas ",
    9=>"Le pays n'existe pas",
    10=>"La date insérée n'est pas valide",
    11=>"Les CGU sont pas validées",
    12=>"Erreur Upload Server",
    13=>"Erreur d'extension de fichier",
    14=>"Erreur de captcha",
    15=>"Erreur image",
    16=>"L'email existe deja",
];
$listOfCountries = [
    "fr" => "France",
    "en" => "Angleterre",
    "es" => "Espagne",
    "be" => "Belgique",
    "ch" => "Suisse",
];
$defaultCountry="fr";
$listOfGenders = [
    "mr" => "Monsieur",
    "mme" => "Madame",
    "autre" => "Autre",
];
$defaultGender="mr";
$avatarExtensionAuthorized = ["png","jpg","gif","jpeg"];
$avatarMaxSize=10000000;