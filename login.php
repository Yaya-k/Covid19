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
    <?php include "navBar.php";?>
    <link rel="stylesheet" href="css/loginCss.css">

</head>

<body>

<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
            <h3>Connexion</h3>
        </div>

        <!-- Login Form -->
        <form role="form" action="index.php" method="post">
            <input type="email" id="login" class="fadeIn second" name="email" placeholder="yaya.kamissokho@..." required>
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="*********" required>
            <input type="submit" class="fadeIn fourth" value="Log In" name="submitLogin">
            <br>
            <?php
            if(isset($_SESSION["error"])){
                ?>
                <span style="color: red"><?php echo $_SESSION["error"];?></span>
                <?php
            }
            ?>
        </form>

        <!-- Remind Passowrd -->
        <div id="formFooter">
            <a class="underlineHover" href="#">Forgot Password?</a>
        </div>

    </div>
</div>
</body>
</html>