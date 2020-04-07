<?php
if (!session_id()) {
    session_start();
}
?>
<?php
include "init.php";
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
    <?php
        $query = "SELECT name, caseNumber FROM employee"; //You don't need a ; like you do in SQL
        $result = mysql_query($query);
        
        echo "<table>"; // start a table tag in the HTML
        
        while($row = mysql_fetch_array($result)){   //Creates a loop to loop through results
        echo "<tr><td>" . $row['name'] . "</td><td>" . $row['caseNumber'] . "</td></tr>";  //$row['index'] the index here is a field name
        }
        
        echo "</table>"; 
    ?>

</div>