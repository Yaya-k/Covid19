<?php
include 'dbbConnexion.php';
if(isset($_GET['vkey'])){
    $vkey=$_GET['vkey'];
    $verified=1;
    $req = $bdd->prepare('UPDATE user SET verified = :verified WHERE vkey = :vkey	');
   $rep= $req->execute(array(
        'verified' => $verified,
        'vkey' => $vkey
    ));
   if ($rep){
       echo "Merci pour votre confirmation";
   }else{
       echo "Nous rencontron un probleme veillier reessayer!";
   }

}else{
    die("cette clef n'est pas valide");
}
