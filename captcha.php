<?php
header('Content-type:image/png');
session_start();
$image = imagecreate(400, 100);

//Colors

//Random RGB values

//background colors 
$c1 = mt_rand(0, 100); //r(ed)
$c2 = mt_rand(0, 100); //g(reen)
$c3 = mt_rand(0, 100); //b(lue)

//font colors
$cf1 = mt_rand(150, 250); //r(ed)
$cf2 = mt_rand(150, 250); //g(reen)
$cf3 = mt_rand(150, 250); //b(lue)

//Random Switch Colors between back and font
$shuffleCouleurIndice = rand(0, 10);
if ($shuffleCouleurIndice%2==0) {
    //Create temp value
    $cTemp1 = $c1;
    $cTemp2 = $c2;
    $cTemp3 = $c3;
    
    $c1=$cf1;
    $c2=$cf2;
    $c3=$cf3;
    
    $cf1=$cTemp1;
    $cf2=$cTemp2;
    $cf3=$cTemp3;
    
}

$couleurBackground = imagecolorallocate($image, $c1, $c2, $c3);
$couleurFont = imagecolorallocate($image, $cf1, $cf2, $cf3);


//Text Random A-Z 0-9 
$police = 5;
$alphabet=range('a', 'z');
$chiffre=range(0, 9);
$alphachiffre= array_merge($alphabet, $chiffre);
shuffle($alphachiffre);
$captcha = '';

//Both attributes for random lenght
$longueur = rand(6, 12);
$debut = rand(0, 6);

foreach ($alphachiffre as $valeur) {
    $captcha .= $valeur;
}
$captcha=substr($captcha, $debut, $longueur);
$_SESSION["captcha"]=$captcha;

$typeFigure=rand(1, 4);

//Ellipse
$x=10;
$y=20;
$largeur=80;
$hauteur=20;
$couleurEllipse=$couleurFont;



//Rectangle
$x1=50;
$y1=25;
$x2=30;
$y2=40;



//Carre
$x3=80;
$y3=80;
$x4=100;
$y4=300;


//Police
$size=16;
$marge= 30;
$font = dirname(__FILE__) . '/fonts/OpenSans-Regular.ttf';
//BOX TEST pris dans openclassroom
$sizeBox = 32;
$box = imagettfbbox($sizeBox, 0, $font, $captcha);
$largeurBox = $box[2] - $box[0];
$hauteurBox = $box[1] - $box[7];
$largeur_lettre = round($largeurBox/strlen($captcha));

//Rotation lettre aléatoire et param switch couleurs pour couleur lettre
for ($i = 0; $i < strlen($captcha); $i++) {
    if ($shuffleCouleurIndice%2==0) {
        $cf1 = mt_rand(0, 100); //r(ed)
        $cf2 = mt_rand(0, 100); //g(reen)
        $cf3 = mt_rand(0, 100); //b(lue)
    }
    else {
        $cf1 = mt_rand(150, 250); //r(ed)
        $cf2 = mt_rand(150, 250); //g(reen)
        $cf3 = mt_rand(150, 250); //b(lue)
    }

    $couleurFont = imagecolorallocate($image, $cf1, $cf2, $cf3);
    $le = $captcha[$i];
    $angle = mt_rand(-35, 35);
    imagettftext($image,mt_rand($size-4,$size),$angle,($i*$largeur_lettre)+$marge, $hauteur+mt_rand(0,$marge/2),$couleurFont, $font, $le);	
}

//PAS FINI
$compteur=0;
for($compteur=0;$compteur<4;$compteur++){
    if($typeFigure==1){
        ImageEllipse ($image, $x, $y, $largeur, $hauteur, $couleurEllipse);
    }
    if($typeFigure==2){
        ImageRectangle ($image, mt_rand(20,$x1), $y1, mt_rand(30,$x2), $y2, $couleurFont);
    }
    if($typeFigure==3){ 
        imageline($image, 2,mt_rand(2,$hauteur), $largeur+$marge, mt_rand(2,$hauteur), $couleurFont);
    }
    if($typeFigure==4){
        ImageRectangle ($image, $x3, $y3, $x4, $y4, $couleurFont);
    }
    }

//AFFICHAGE DU CAPTCHA
imagepng($image);



//captcha unique avec des chiffres et des lettres
// UNe taille dynamique
// Couleur de fond dynamique
//Couleur des caractères dynamiques
//Police (doit se trouver dans un dossier font et c'est le php qui liste toutes les polices dispo) et taille des caractères dynamique
//nombre de Formes géométriques aléatoires sur l'image 
//Angle des caractères aléatoires
//Attention à la lisibilité
//OPTION (mp3) Lecture des caractères par le navigateur



?>