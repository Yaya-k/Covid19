<?php if(!session_id()) {
    session_start();
}?>
<?php
include "init.php";
include "navBar.php";
?>

<?php


    $email = $_SESSION["email"];
    //  Récupération de l'utilisateur et de son pass hashé
    $req = $bdd->prepare('SELECT nom,situation,age,pays_de_provenance,groupe_sanguin,comment		 FROM user WHERE email = :email');
    $req->execute(array(
        'email' => $email));

    $resultat = $req->fetch();
    $nom=$resultat['nom'];
    $situation=$resultat['situation'];
    $pays_de_provenance=$resultat['pays_de_provenance'];
    $groupe_sanguin=$resultat['groupe_sanguin'];
    $comment=$resultat['comment'];
    $age=$resultat['age'];

// Comparaison du pass envoyé via le formulaire avec la base



/*$reponseStatic = $bdd->query('SELECT * FROM staticcity');
$_SESSION['staticcity']=$reponseStatic->fetch();
echo sizeof($_SESSION['staticcity']);
var_dump(count($_SESSION['staticcity']));
$tttt=array();
while ($rest=$reponseStatic->fetch()){
    $tttt.array_push($rest['nom']);
    echo $rest['nom'];

    ?>
<br>
    <?php
}*/


?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>



</head>
<body style="">

<form role="form" action="index.php" method="post">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <label for="usr">Nom:</label>
                <input type="text" class="form-control" id="nom" name="nom" <?php echo "value= $nom";?> ">
            </div>

        </div>
        <div class="row">

            <div class="col-lg-5">
                <label for="">Localisation</label>
                <select class="form-control search-slt" id="localisation" name="localisation" required >
                    <option value="SelectUneCategorie" selected disabled>Select une Localisation</option>
                    <optgroup label="DAKAR">
                        <option value="mermoz">Mermoz</option>
                        <option value="parcelles_assainies">Parcelles assainies</option>
                        <option value="grand_dakar">Grand Dakar</option>
                        <option value="dakar_plateau">Dakar plateau</option>
                        <option value="almadies">Almadies</option>
                        <option value="ngor">Ngor</option>
                        <option value="quakam">Quakam</option>
                        <option value="yoff">Yoff</option>
                        <option value="fann_point_e">Fann point E</option>
                        <option value="colobanne">Colobanne</option>
                        <option value="medina">Medina</option>
                        <option value="derkle">Derkle</option>
                        <option value="rufisque">Rufisque</option>


                    </optgroup>

                    <optgroup label="DIOURBEL" disabled>


                        <option value="diourbel">Diourbel</option>
                        <option value="tiebo">tiébo</option>
                        <option value="mbacke">Mbacké</option>
                        <option value="touba">Touba</option>

                    </optgroup>


                    <optgroup label="FATICK" disabled>

                        <option value="fatick">Fatick</option>
                        <option value="gossas">Gossas</option>
                        <option value="foundiougne">Foundiougne</option>
                    </optgroup>

                    <optgroup label="KAFFRINE" disabled>


                        <option value="kaffrine">Kaffrine</option>
                        <option value="mbouki">Mbouki</option>
                        <option value="koungheul">Koungheul</option>
                        <option value="hoddar">Hoddar</option>
                    </optgroup>

                    <optgroup label="KAOLACK" disabled>


                        <option value="kaolack">Kaolack</option>
                        <option value="nioroDuRip">Nioro du Rip</option>
                        <option value="mbadakhoune">Mbadakhoune</option>
                        <option value="guinguineo">Guinguinéo</option>
                    </optgroup>
                    <optgroup label="KEDOUGOU" disabled>


                        <option value="kedougou">Kédougou</option>
                        <option value="salemata">Salémata</option>
                        <option value="saraya">Saraya</option>
                    </optgroup>
                    <optgroup label="KOLDA" disabled>


                        <option value="kolda">Kolda</option>
                        <option value="medinaYoroFoulah">Médina Yoro Foulah</option>
                        <option value="Velingara">Vélingara</option>
                    </optgroup>
                    <optgroup label="LOUGA" disabled>


                        <option value="louga">Louga</option>
                        <option value="kebemer">Kébémer</option>
                        <option value="linguere">Linguère</option>
                    </optgroup>

                    <optgroup label="MATAM" disabled>


                        <option value="matam">Matam</option>
                        <option value="kanel">Kanel</option>
                        <option value="ranerouFerlo">Ranérou-Ferlo</option>
                    </optgroup>
                    <optgroup label="SAINT-LOUIS" disabled>


                        <option value="saintLouis">Saint Louis</option>
                        <option value="podor">Podor</option>
                    </optgroup>
                    <optgroup label="SEDHIOU" disabled>


                        <option value="sedhiou">Sédhiou</option>
                        <option value="goudoump">Goudoump</option>
                    </optgroup>
                    <optgroup label="TAMBACOUNDA" disabled>


                        <option value="tambacounda">Tambacounda</option>
                        <option value="bakel">Bakel</option>
                        <option value="goudiry">Goudiry</option>
                    </optgroup>
                    <optgroup label="THIES" disabled>


                        <option value="thies">Thiés</option>
                        <option value="tivaouane">Tivaouane</option>
                        <option value="mbour">Mbour</option>
                    </optgroup>
                    <optgroup label="ZIGUINCHOR" disabled>


                        <option value="ziguinchor">Ziguinchor</option>
                        <option value="bignona">Bignona</option>
                    </optgroup>
                </select>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-5">
                <label for="usr">Age:</label>
                <input type="number" class="form-control" id="age" name="age" <?php echo "value= $age";?>  >
            </div>
        </div>

        <div class="row">

            <div class="col-lg-5">
                <label for="usr">Pays de provenance:</label>
                <input type="text" class="form-control" id="pays" name="pays" <?php echo "value= $pays_de_provenance";?> >
            </div>
        </div>
        <div class="row">

            <div class="col-lg-5">
                <label for="usr">Groupe sanguin:</label>
                <input type="text" class="form-control" id="sanguin" name="gSanguin" <?php echo "value= $groupe_sanguin";?> >
            </div>
        </div>

        <div class="row">

            <div class="col-lg-5">
                <label>Situation:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gridRadios"  id="gridRadios1" value="1" <?php echo $situation==1?'checked':''?> >
                    <label class="form-check-label" for="gridRadios1">
                        Positive:
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="0" <?php echo $situation==0?'checked':''?> >
                    <label class="form-check-label" for="gridRadios2">
                        Negative:
                    </label>
                </div>
                <div class="form-check disabled">
                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="2" <?php echo $situation==2?'checked':''?> >
                    <label class="form-check-label" for="gridRadios3">
                        Pas encore tester
                    </label>
                </div>
            </div>

        </div>
        <br>

        <div class="row">

            <div class="col-lg-5">
                <label for="usr">Commentaire:</label><br>
                <textarea name="commentaire" id="commentaire" <?php echo "value= $comment";?>  ></textarea>
            </div>
        </div>
        <br>
        <div class="row">

            <div class="col-lg-4">
                <button type="submit" class="btn btn-primary" id="enregistrerChanges" name="enregistrerChangement" >Enregistrer </button>

            </div>
        </div>



    </div>


</form>

<br>
<br>
<br>






</body>
</html>