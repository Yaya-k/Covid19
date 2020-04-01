<?php
/**
 * Created by PhpStorm.
 * User: yayak
 * Date: 25/09/2020
 * Time: 15:16
 */
try // ici je me connecte a la base
{
    $bdd = new PDO('mysql:host=localhost;port=3308;dbname=covid19;charset=utf8', 'root', '');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

// ici je me connecte a la base annonce_en_cours