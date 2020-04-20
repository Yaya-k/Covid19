


<link rel="stylesheet" href="css/navBar.css">

<nav class="navbar navbar-inverse navbar-static-top custom-navbar" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
              <div type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                  <?php
                  if(isset($_SESSION['email'])){
                    ?>
                      <a href="form.php"> <span class="glyphicon glyphicon-user"></span>
                      </a>
                      <?php
                  }else{
                      ?>
                      <a href="login.php"> <span class="glyphicon glyphicon-user"></span>
                      </a>
                      <?php
                  }
                  ?>

              </div>

            <!--  <a class="navbar-brand" rel="home" href="#" title="Help"> Accueille</a>-->


           <div class="nav-icons">
                <a href="index.php" > <span class="sur">Home</span>
                </a>
                <a href="#"> <span class="sur">S'informer</span>
                </a>

            </div>
        </div>
        <div class="navbar-collapse collapse" id="navbar-collapse-1">
            <!-- Non-collapsing right-side icons -->
            <ul class="nav navbar-nav navbar-right">
                <?php if (isset($_SESSION['email'])){
                    ?>
                    <li ><a href="form.php" style="color: black;" >Profile</a>

                    </li>
                    <li><a href="index.php?action=deconnexion" style="color: black;" >Déconnexion</a>

                    </li>
                <?php
                }else
                {
                    ?>

                    <li ><a href="login.php" style="color: black;" >Connection</a>

                    </li>
                    <li><a href="inscription.php" style="color: black;" >Inscription</a>

                    </li>
                    <?php
                }

                ?>


            </ul>
        </div>
    </div>
</nav>

