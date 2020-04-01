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


// ici je gere l'inscription des nouveau membres
if (htmlspecialchars(isset($_POST['registerButton']))) {
// je me connecte a la base de donner

    $nom = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT   user (nom, email, password) VALUES(?,?,?)";
    $stmtinsert = $bdd->prepare($sql);
    $result = $stmtinsert->execute([$nom, $email, $password]);
    if ($result) {
        echo 'Successfully saved.';
    } else {
        echo 'There were erros while saving the data.';
    }

    $_SESSION["email"] = $_POST["email"];

}

?>




<?php

if (htmlspecialchars(isset($_POST["submitLogin"]))) {
    $email = $_POST["email"];
    //  Récupération de l'utilisateur et de son pass hashé
    $req = $bdd->prepare('SELECT id, password FROM user WHERE email = :email');
    $req->execute(array(
        'email' => $email));

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
include "navBar.php";
?>
<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
        height: 80%;
        width: 70%;
        float: left;
    }
    #tab{
        float: right;
        width: 30%;

    }

    /* Optional: Makes the sample page fill the window. */

</style>
<div class="container">
    <div class="row">
        <div class="col-6">
            <div id="map"></div>

        </div>
        <div class="col-6" id="tab">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Dakar
                    <span class="badge badge-primary badge-pill">14</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Lougua
                    <span class="badge badge-primary badge-pill">2</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Thies
                    <span class="badge badge-primary badge-pill">1</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Dakar
                    <span class="badge badge-primary badge-pill">14</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Lougua
                    <span class="badge badge-primary badge-pill">2</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Thies
                    <span class="badge badge-primary badge-pill">1</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Dakar
                    <span class="badge badge-primary badge-pill">14</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Lougua
                    <span class="badge badge-primary badge-pill">2</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Thies
                    <span class="badge badge-primary badge-pill">1</span>
                </li>
            </ul>
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
            zoom: 8,
            center: {lat: 14.535415, lng: -14.825055},
            mapTypeId: 'terrain'
        });

        // Construct the circle for each value in citymap.
        // Note: We scale the area of the circle based on the population.
        for (var city in citymap) {
            // Add the circle for this city to the map.
            var cityCircle = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,

                map: map,
                center: citymap[city].center,
                radius: Math.sqrt(citymap[city].contaminer) * 100,

            });


        }

        for (var city in citymap){
            var marker = new google.maps.Marker({
                position: citymap[city].center,
                label: { color: '#000000', fontWeight: 'bold', fontSize: '14px', text: citymap[city].contaminer.toString() },
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
