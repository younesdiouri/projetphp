<?php
    include "header.php";
?>
 
<section>
 
<?php
 
    // Commentaire sur une ligne
    /*
        Sur plusieurs lignes
           
    $firstnameUser = "yves";
    echo "Bonjour ".$firstnameUser;
 
 
    $number1 = 3;
    $number2 = 4;
 
    echo "Le résultat de ".$number1." + ".$number2." donne ".($number1+$number2);
       
 
    $cpt = 1;
    echo $cpt; //1
    $cpt = $cpt+1;
    echo $cpt; //2
    $cpt += 1;
    echo $cpt; //3
    $cpt++;
    echo $cpt; //4
    ++$cpt;
    echo $cpt; //5
    echo $cpt++; //5
    echo $cpt; //6
    echo ++$cpt; //7
   
 
    $age = 22;
 
    if($age === 18) echo "Vous etes tout juste majeur";
    else if($age > 18) echo "Vous etes majeur";
    else echo "Vous etes mineur";
    */
 
    $number1 = 12;
    $number2 = 2;
    $signe = "-";
    /*
    if($signe == "+"){
        $result = $number1+$number2;
    }else if($signe == "*"){
        $result = $number1*$number2;
    }else if($signe == "-"){
        $result = $number1-$number2;
    }else if($signe == "/" && $number2!=0){
        $result = $number1/$number2;
    }else{
        $result = "ERROR";
    }
 
    (conditon)?true:false;
 
 
 
    switch ($signe) {
        case '+':
            $result = $number1+$number2;
            break;
        case '*':
            $result = $number1*$number2;
            break;
        case '-':
            $result = $number1-$number2;
            break;
        case '/':
            $result = (!$number2)?"ERROR":$number1/$number2;
            break;
        default:
            $result = "ERROR";
            break;
    }
 
    echo "Le résultat de ".$number1." ".$signe." ".$number2." donne ".$result;
 
 
 
    $student = ["lastname"=>"ROCCO", "firstname"=>"Fabio", "age"=>21];
 
    echo "<pre>";
    print_r($student);
    echo "</pre>";
 
 
 
   
 
    $class = [
                ["lastname"=>"ROCCO", "firstname"=>"Fabio", "age"=>21],
                ["lastname"=>"NOUVE", "firstname"=>"YANN", "age"=>21],
                ["lastname"=>"WAZIRI", "firstname"=>"Diego", "age"=>21],
 
             ];
 
?>
 
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Age</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($class as $key => $value) {
                echo "<tr>";
                echo "<td>".$key."</td>";
                echo "<td>".$value["lastname"]."</td>";
                echo "<td>".$value["firstname"]."</td>";
                echo "<td>".$value["age"]."</td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>
 
<?php
 
 
    for( $cpt=0 ; $cpt < 100 ; $cpt++ ){
        echo $cpt."<br>";
    }
 
 
    $i = 0;
    while($i<100){
        echo $i."<br>";
        $i++;
    }
 
 
    do{
 
    }while();
 
   
 
    //Afficher les X premiers nombres premiers
    $start = microtime();
    $x = 10000;
    $numberTested = 2;
    while ($x>0) {
       
        $isFirst = true;
 
        for($i=2; $i<$numberTested; $i++){
            if($numberTested % $i == 0){
                $isFirst = false;
                break;
            }
        }
 
        if($isFirst){
            echo $numberTested."<br>";
            $x--;
        }
        $numberTested++;
    }
    echo microtime()-$start;
   
 
 
    function helloWord(){
        echo "Hello word<br>";
    }
 
    helloWord();
 
 
    function helloYou($firstname, $lastname = null){
        echo "Hello ".cleanWord($firstname)." ".cleanWord($lastname, true)."<br>";
    }
   
 
    helloYou("éyves", "skrzypczyk");
    helloYou("yves");
 
    function cleanWord($word, $allUpper = false){
        $word = trim($word);
 
        if($allUpper){
            replaceAccents($word);
            $word = strtoupper($word);
        }else{
            $firstChar = mb_substr($word, 0, 1, 'utf-8');
            replaceAccents($firstChar);
            $word = $firstChar.mb_substr($word, 1, strlen($word), 'utf-8');
            $word = strtolower($word);
            $word = ucfirst($word);
        }
 
        return $word;
    }
 
    function replaceAccents(&$word){
        $word = str_replace(
                ['à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'],
 
                ['a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'],
 
                $word);
    }
 
 
    $age = 13;
 
    function showAge(){
        global $age;
        echo $age;
    }
 
    showAge();
 
 
 
 
    */
?>
 
 
 
 
 
</section>
 
<?php
    include "footer.php";
?>