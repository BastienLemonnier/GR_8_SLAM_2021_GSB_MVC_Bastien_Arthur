<?php

namespace App\Models;

class Modele
{
    const LISTEMOIS = [ 1 => "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"];

    public function isUserExists($login)
    {
        $db = db_connect("guest");

        $sql = "SELECT EXISTS(SELECT * FROM Visiteur WHERE login = ?);";
        $resultat = $db -> query($sql, [$login]);
        $resultat = $resultat -> getResult();

        return $resultat[0][0];
    }

    public function getUserId($login)
    {
        $db = db_connect("auth");

        $sql = "SELECT id FROM Visiteur WHERE login = ?;";
        $resultat = $db -> query($sql, [$login]);
        $resultat = $resultat -> getResult();

        return $resultat[0][0];
    }

    public function getUserPassword($login)
    {
        $db = db_connect("guest");

        $sql = "SELECT mdp FROM Visiteur WHERE login = ?;";
        $resultat = $db -> query($sql, [$login]);
        $resultat = $resultat -> getResult();

        return $resultat[0][0];
    }

    public function getUserName($login)
    {
        $db = db_connect("guest");

        $sql = "SELECT nom, prenom FROM Visiteur WHERE login = ?;";
        $resultat = $db -> query($sql, [$login]);
        $resultat = $resultat -> getResult();

        $name['prenom'] = $resultat[0]['prenom'];
        $name['name'] = $resultat[0]['nom'];

        return $name;
    }

    public function getFraisMoisChoisis($numMois)
    {
        $db = db_connect("auth");
        session_start();

        $sql = "SELECT quantite, id FROM LigneFraisForfait INNER JOIN FraisForfait ON LigneFraisForfait.idFraisForfait = FraisForfait.id
        WHERE idVisiteur = ? AND mois LIKE ? ORDER BY FraisForfait.id;";
        $resultat = $db -> query($sql, [
            getUserId($_SESSION['login']),
            LISTEMOIS[$numMois]
        ]);
        $resultat = $resultat -> getResult();

        $fraisForfait = array ("ETP" => 0, "KM" => 0, "NUI" => 0, "REP" => 0); //initialiser le tableau du return

        for($i = 0; $i < 4; $i ++) //pour chaque résultat
        {
            $id = $resultat[$i]['id']; //recup id de la quantité
            if(!empty($resultat[$i]['quantite'])) //si il y a une quantité
            {
                $fraisForfait[$id] = $resultat[$i]['quantite']; //changer la quantité de l'id donné
            }
        }

        $_SESSION['FraisForfait'] = $fraisForfait;
    }
}