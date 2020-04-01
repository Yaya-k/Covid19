<?php
if(!session_id()) {
    session_start();
}
?>
<?php
include "init.php";
?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>The HTML5 Herald</title>
    <meta name="COV19" content="The HTML5 Herald">
    <meta name="Yaya" content="Site">

    <link rel="stylesheet" href="css/loginCss.css">
    <?php include "navBar.php";?>
</head>

<body>

<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
            <h3>Inscription</h3>
        </div>

        <!-- Login Form -->
        <form role="form" action="index.php" method="post">
            <input type="text" id="login" class="fadeIn second" name="name" placeholder="Nom" required>
            <input type="email" id="login" class="fadeIn second" name="email" placeholder="email" required>

            <input type="password" id="password" class="fadeIn third" name="password" placeholder="password" required minlength=8 onkeyup='check();'>
            <input type="password" id="confirmPassword" class="fadeIn third" name="Conpassword" placeholder="Confirm password" required minlength=8 onkeyup='check();'>
           <br>
            <span id="message"></span>
            <br>
            <label>
                <input type="checkbox" required>
                J'accepte les condition generales
            </label>
            <input type="submit" id="submit" class="fadeIn fourth" value="Soumettre" name="registerButton" disabled="">
        </form>

        <!-- Remind Passowrd -->
        <div id="formFooter">
            <a class="underlineHover" href="login.php">Se connecter?</a>
        </div>

    </div>
</div>
<script>
    function check() {

        if (document.getElementById('password').value ===
            document.getElementById('confirmPassword').value ) {


            document.getElementById('message').style.color = 'green';
            document.getElementById('message').innerHTML = 'matching';
            document.getElementById('submit').disabled = false;

        } else {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'not matching';
            document.getElementById('submit').disabled = true;

        }

        document.getElementById('message').hidden = document.getElementById('password').value === "" || document.getElementById('confirmPassword').value === "";
    }
</script>
</body>

</html>