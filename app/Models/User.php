<?php

namespace App\Models;

class User
{
    public static function isUserExists($login)
    {
        $db = db_connect("guest");

        $sql = "SELECT EXISTS(SELECT * FROM Visiteur WHERE login = ?) AS 'exist';";
        $resultat = $db -> query($sql, [$login]);
        $resultat = $resultat -> getResult();

        return $resultat[0] -> exist;
    }

    public static function getUserId($login)
    {
        $db = db_connect("auth");

        $sql = "SELECT id FROM Visiteur WHERE login = ? LIMIT 1;";
        $resultat = $db -> query($sql, [$login]);
        $resultat = $resultat -> getResult();

        return $resultat[0] -> id;
    }

    public static function getUserPassword($login)
    {
        $db = db_connect("guest");

        $sql = "SELECT mdp FROM Visiteur WHERE login = ? LIMIT 1;";
        $resultat = $db -> query($sql, [$login]);
        $resultat = $resultat -> getResult();

        return $resultat[0] -> mdp;
    }

    public static function getUserName($login)
    {
        $db = db_connect("guest");

        $sql = "SELECT nom, prenom FROM Visiteur WHERE login = ?;";
        $resultat = $db -> query($sql, [$login]);
        $resultat = $resultat -> getResult();

        $name['prenom'] = $resultat[0] -> prenom;
        $name['nom'] = $resultat[0] -> nom;

        return $name;
    }
}