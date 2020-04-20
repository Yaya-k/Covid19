<?php
if (!session_id()) {
    session_start();
}
?>
<?php
include "init.php";
include 'navBar.php';
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
$nomPlotCity=$_SESSION['nomPlotCity'];
$latPlotCity=$_SESSION['latPlotCity'];
$lngPlotCity=$_SESSION['lngPlotCity'];
$confirmedPlotCity=$_SESSION['confirmedPlotCity'];
$gueriPlotCity=$_SESSION['gueriPlotCity'];
$communautairePlotCity=$_SESSION['communautairePlotCity'];
$mortPlotCity=$_SESSION['mortPlotCity'];

?>
<style>

</style>



<body onLoad="c1();">
<table class="table">
    <thead>
    <tr>
        <th scope="col">Localite</th>
        <th scope="col">CONFIRMED</th>
        <th scope="col">REPORTED </th>
        <th scope="col">RECOVERED</th>
        <th scope="col">Communautaire</th>
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
            <td><?php echo $communautairePlotCity[$i] ;?></td>

        </tr>
        <?php
    }
    ?>



    </tbody>

</table>
<div align="center" style="position:absolute;" id="a"><h1 style="color: red">Keur massar ; Rufisque ; Mbao ; Yembeul ; Parcelle ; Ouakame</h1> </div>
</body>


<script type="text/javascript">
    rd=10;
    la=screen.availWidth;

    function c1()
    {
        rd+=10;
        if (rd>la) // selon longueur texte
            rd=200;
        el=document.getElementById("a");
        el.style.left=rd;
        setTimeout("c1()", 100); // vitesse de défilement
    }
</script>
