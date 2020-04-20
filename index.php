<?php
if (!session_id()) {
    session_start();
}
?>
<?php
include "init.php";
?>
<?php
if(htmlspecialchars(isset($_GET["action"])) )
{
    if(isset($_GET["action"])=="deconnexion")
    {
        session_destroy();
    }

}
?>
<?php
// je load les données de city
$reponseDynaCity = $bdd->query('SELECT nom, lat,lng	,confirmed,mort	,gueri,communautaire FROM city');
$nomPlotCity=array();
$latPlotCity=array();
$lngPlotCity=array();
$confirmedPlotCity=array();
$mortPlotCity=array();
$gueriPlotCity=array();
$communautairePlotCity=array();





while ($val=$reponseDynaCity->fetch()){
    $nomPlotCity[]=$val['nom'];

    $latPlotCity[]=$val['lat'];
    $lngPlotCity[]=$val['lng'];
    $confirmedPlotCity[]=$val['confirmed'];
    $mortPlotCity[]=$val['mort'];
    $gueriPlotCity[]=$val['gueri'];
    $communautairePlotCity[]=$val['communautaire'];

}
// je stock les valeur dans dans session
$_SESSION['nomPlotCity']=$nomPlotCity;
$_SESSION['latPlotCity']=$latPlotCity;
$_SESSION['lngPlotCity']=$lngPlotCity;
$_SESSION['confirmedPlotCity']=$confirmedPlotCity;
$_SESSION['gueriPlotCity']=$gueriPlotCity;
$_SESSION['communautairePlotCity']=$communautairePlotCity;
$_SESSION['mortPlotCity']=$mortPlotCity;
$_SESSION['nombreElements']=count($nomPlotCity);


?>

<?php


// ici je gere l'inscription des nouveau membres
if (htmlspecialchars(isset($_POST['registerButton']))) {
// je me connecte a la base de donner

    $nom = $_POST['name'];
    $email = $_POST['email'];


    //  Récupération de l'utilisateur et de son pass hashé
    $req = $bdd->prepare('SELECT id, password FROM user WHERE email = :email');
    $req->execute(array(
        'email' => $email
    ));

    $resultat = $req->fetch();
    if($resultat){
        ?>
        <script>
            alert("votre adress email est deja utiliser! veuillez vous connecter")
        </script>
        <?php
    }else{

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $vkey=md5(time().$nom);

        $sql = "INSERT   user (nom, email, password,vkey) VALUES(?,?,?,?)";
        $stmtinsert = $bdd->prepare($sql);
        $result = $stmtinsert->execute([$nom, $email, $password,$vkey]);
        if ($result) {
            // send email
            $subject="EMAIL VERIFICATION";
            $message="<a href= 'http://trackcovid19.alwaysdata.net/verified.php?vkey=$vkey'> Confirmer votre inscription</a>";

            $headers="From: trackcovid19@alwaysdata.net \r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            ini_set('SMTP','smtp-trackcovid19.alwaysdata.net');

            mail($email,$subject,$message,$headers);
       //



        } else {
            echo 'There were erros while saving the data.';
        }

        $_SESSION["email"] = $_POST["email"];
    }




}

?>




<?php

if (htmlspecialchars(isset($_POST["submitLogin"]))) {
    $email = $_POST["email"];
    $verified=1;
    //  Récupération de l'utilisateur et de son pass hashé
    $req = $bdd->prepare('SELECT id, password FROM user WHERE email = :email and verified=:verified');
    $req->execute(array(
        'email' => $email,
        'verified'=>$verified
        ));

    $resultat = $req->fetch();

    // Comparaison du pass envoyé via le formulaire avec la base
    $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);

    if (!$resultat) {
        $_SESSION["error"] = "Mauvais identifiant mot de passe !";
        header("location:login.php");
        return;
    } else {
        if ($isPasswordCorrect) {
            $_SESSION['id'] = $resultat['id'];
            $_SESSION['email'] = $email;

            $_SESSION["error"] = '';

        } else {
            $_SESSION["error"] = "Mauvais identifiant mot de passe !";
            header("location:login.php");

            return;
        }
    }


}


?>
<?php
if(isset($_POST['enregistrerChangement'] )){
    $email=$_SESSION['email'];
    if(isset($_POST['age'])){
        $age=$_POST['age'];

        $req = $bdd->prepare('UPDATE user SET age = :age WHERE email = :email');
        $req->execute(array(
            'age' => $age,
            'email' => $email
        ));
    }
    if(isset($_POST['nom'])){
        $nom=$_POST['nom'];

        $req = $bdd->prepare('UPDATE user SET nom = :nom WHERE email = :email');
        $req->execute(array(
            'nom' => $nom,
            'email' => $email
        ));

    }








    if(isset($_POST['pays'])){
        $pays_de_provenance=$_POST['pays'];

        $req = $bdd->prepare('UPDATE user SET pays_de_provenance = :pays_de_provenance WHERE email = :email');
        $req->execute(array(
            'pays_de_provenance' => $pays_de_provenance,
            'email' => $email
        ));

    }
    if(isset($_POST['gSanguin'])){
        $groupe_sanguin=$_POST['gSanguin'];

        $req = $bdd->prepare('UPDATE user SET groupe_sanguin	 = :groupe_sanguin WHERE email = :email');
        $req->execute(array(
            'groupe_sanguin' => $groupe_sanguin,
            'email' => $email
        ));

    }

    if(isset($_POST['gridRadios'])){
        $situation=(int)$_POST['gridRadios'];
        $req = $bdd->prepare('UPDATE user SET situation = :situation WHERE email = :email');
        $req->execute(array(
            'situation' => $situation,
            'email' => $email
        ));

        if($situation==1){


            if(isset($_POST['localisation'])){

                $nom=$_POST['localisation'];
                $req = $bdd->prepare('SELECT nom, confirmed, mort, gueri FROM city WHERE nom = :nom');
                $req->execute(array(
                    'nom' => $nom
                ));

                $resultat = $req->fetch();

                 //
                $req2 = $bdd->prepare('SELECT lat, lng FROM staticcity WHERE nom = :nom');
                $req2->execute(array(
                    'nom' => $nom
                ));

                $resultat2 = $req2->fetch();
                $lat=$resultat2['lat'];
                $lng=$resultat2['lng'];
                 //

                if($resultat){

                    $confirmed=$resultat['confirmed'];
                    $confirmed=$confirmed+1;
                    $req = $bdd->prepare('UPDATE city SET confirmed = :confirmed WHERE nom = :nom');
                    $req->execute(array(
                        'confirmed' => $confirmed,
                        'nom' => $nom
                    ));
                }else{
                    // ici on insert
                    // pour l'instand la ville mere c dakar
                    $ville_mere="dakar";
                    $caseNumber=1;

                    $sql = "INSERT   city (nom, lat	, lng,confirmed	,ville_mere) VALUES(?,?,?,?,?)";
                    $stmtinsert = $bdd->prepare($sql);
                    $result = $stmtinsert->execute([$nom, $lat, $lng,$caseNumber,$ville_mere]);

                }


            }





        }

    }




}
?>


<?php
include "navBar.php";
?>
<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
        height: 80%;
        width: 90%;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 10px;

    }
   #tab1{
       width: 47%;
       float: left;

   }
   #tab2{
       width: 47%;
       float: right;
   }
   #tabs{
       margin-left: 5%;
       margin-right: 5%;
   }
   #ligne:hover{
       background-color: #39ace7;
   }

    /* Optional: Makes the sample page fill the window. */

</style>



<div id="map"></div>
<div id="tabs">
    <div class="container" id="tab1">

        <ul class="list-group" >
            <li class="list-group-item d-flex justify-content-between align-items-center" id="ligne" style="cursor: pointer;" onclick="initMap()" data-toggle="modal" data-target="#exampleModal">
                Dakar
                <span class="badge badge-primary badge-pill" >241</span>
            </li >
            <li class="list-group-item d-flex justify-content-between align-items-center" id="ligne" style="cursor: pointer;">
                Diourbel
                <span class="badge badge-primary badge-pill">31</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" id="ligne" style="cursor: pointer;">
                Fatick
                <span class="badge badge-primary badge-pill">1</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" id="ligne" style="cursor: pointer;">
                Kaffrine
                <span class="badge badge-primary badge-pill">0</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" id="ligne" style="cursor: pointer;">
                Kaolack
                <span class="badge badge-primary badge-pill">0</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" id="ligne" style="cursor: pointer;">
                Kédougou
                <span class="badge badge-primary badge-pill">0</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" id="ligne" style="cursor: pointer;">
                Kolda
                <span class="badge badge-primary badge-pill">7</span>
            </li>

        </ul>


    </div>

    <div class="container" id="tab2">

        <ul class="list-group" >


            <li class="list-group-item d-flex justify-content-between align-items-center" id="ligne" style="cursor: pointer;">
                Louga
                <span class="badge badge-primary badge-pill">29</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" id="ligne" style="cursor: pointer;">
                Matam
                <span class="badge badge-primary badge-pill">0</span>
            </li>


            <li class="list-group-item d-flex justify-content-between align-items-center" id="ligne" style="cursor: pointer;">
                Saint-Louis
                <span class="badge badge-primary badge-pill">5</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" id="ligne" style="cursor: pointer;">
                Sédhiou
                <span class="badge badge-primary badge-pill">0</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" id="ligne" style="cursor: pointer;">
                Tambacounda
                <span class="badge badge-primary badge-pill">21</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" id="ligne" style="cursor: pointer;">
                Thiès
                <span class="badge badge-primary badge-pill">26</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" id="ligne" style="cursor: pointer;">
                Ziguinchor
                <span class="badge badge-primary badge-pill">5</span>
            </li>

        </ul>


    </div>

</div>





<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="text-align: center;">Dakar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Localite</th>
                        <th scope="col">CONFIRMED</th>
                        <th scope="col">REPORTED </th>
                        <th scope="col">RECOVERED</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    for($i=0;$i<count($nomPlotCity);$i++){
                        ?>
                        <tr>
                            <td><?php echo $nomPlotCity[$i] ;?></td>
                            <td><?php echo $confirmedPlotCity[$i] ;?></td>
                            <td><?php echo $mortPlotCity[$i] ;?></td>
                            <td><?php echo $gueriPlotCity[$i] ;?></td>
                        </tr>
                        <?php
                    }
                    ?>



                    </tbody>

                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="window.location.href='city.php?city=dakar'">Plus</button>

                <button type="button" class="btn btn-secondary" data-dismiss="modal"   >Fermer</button>

            </div>
        </div>
    </div>
</div>


<script>
    // This example creates circles on the map, representing populations in North
    // America.

    // First, create an object containing LatLng and population for each city.
    var citymap = {
        touba  : {
            center: {lat: 14.85, lng: -15.88333},
            contaminer: 27000
        },
        dara: {
            center: {lat:15.34844 , lng: -15.47993},
            contaminer: 8000
        },
        kaolack : {
            center: {lat: 14.1825, lng: -16.25333},
            contaminer: 3000
        },
        kaffrine: {
            center: {lat: 14.10594, lng: -15.5508},
            contaminer: 6000
        }
    };

    function initMap() {
        // Create the map.
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: {lat: 14.7057896, lng: -17.4554731},
            mapTypeId: 'terrain'
        });

        // Construct the circle for each value in citymap.
        // Note: We scale the area of the circle based on the population.

        var nomPlotCity = <?php echo json_encode($_SESSION['nomPlotCity']); ?>;
        var latPlotCity = <?php echo json_encode($_SESSION['latPlotCity']); ?>;
        var lngPlotCity = <?php echo json_encode($_SESSION['lngPlotCity']); ?>;
        var confirmedPlotCity = <?php echo json_encode($_SESSION['confirmedPlotCity']); ?>;
        var gueriPlotCity = <?php echo json_encode($_SESSION['gueriPlotCity']); ?>;
        var communautairePlotCity = <?php echo json_encode($_SESSION['communautairePlotCity']); ?>;
        var mortPlotCity = <?php echo json_encode($_SESSION['mortPlotCity']); ?>;




       for (var i=0;i<nomPlotCity.length;i++){
            var cityCircle = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,

                map: map,
                center: {lat: parseFloat(latPlotCity[i]) , lng: parseFloat(lngPlotCity[i]) },
                radius: Math.sqrt(parseFloat(confirmedPlotCity[i])) * 100,

            });
        }

        for (var i=0;i<nomPlotCity.length;i++){
            var marker = new google.maps.Marker({
                position: {lat: parseFloat(latPlotCity[i]) , lng: parseFloat(lngPlotCity[i]) },
                label: { color: '#000000', fontWeight: 'bold', fontSize: '14px', text: parseInt(confirmedPlotCity[i]).toString() },
                optimized: false,
                visible: true
            });
            marker.setMap(map);
        }






    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuGNAUyOVsfH_5u2ZlNBzPSoogI9aNAKo&callback=initMap">
</script>
