<?php

namespace App\Models;

class Modele
{
    const LISTEMOIS = [ 1 => "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"];

    public function getFraisMoisChoisis($numMois)
    {
        $db = db_connect("auth");

        $_SESSION['mois']['num'] = $numMois;
        $_SESSION['mois']['libelle'] = $this::LISTEMOIS[$numMois];

        $sql = "SELECT quantite, id FROM LigneFraisForfait INNER JOIN FraisForfait ON LigneFraisForfait.idFraisForfait = FraisForfait.id
        WHERE idVisiteur = ? AND mois LIKE ? ORDER BY FraisForfait.id;";
        $resultat = $db -> query($sql, [
            User::getUserId($_SESSION['login']),
            $_SESSION['mois']['libelle']
        ]);
        $resultat = $resultat -> getResult();

        $fraisForfait = array ("ETP" => 0, "KM" => 0, "NUI" => 0, "REP" => 0); //initialiser le tableau du return

        for($i = 0; $i < 4; $i ++) //pour chaque résultat
        {
            if(isset($resultat[$i]))
            {
                $id = $resultat[$i] -> id; //recup id de la quantité
                if(!empty($resultat[$i] -> quantite)) //si il y a une quantité
                {
                    $fraisForfait[$id] = $resultat[$i] -> quantite; //changer la quantité de l'id donné
                }
            }
        }

        $_SESSION['FraisForfait'] = $fraisForfait;

        $sql = ('SELECT libelle, date, montant FROM LigneFraisHorsForfait WHERE idVisiteur = ? AND mois LIKE ?');
        $resultat = $db -> query($sql, [
            User::getUserId($_SESSION['login']),
            $_SESSION['mois']['libelle']
        ]);
        $resultat = $resultat -> getResult();

        $_SESSION['FraisHF'] = array();

        for($i = 0; $i < count($resultat); $i ++)
        {
            $_SESSION['FraisHF'][$i]['date'] = $resultat[$i] -> date;
            $_SESSION['FraisHF'][$i]['libelle'] = $resultat[$i] -> libelle;
            $_SESSION['FraisHF'][$i]['montant'] = $resultat[$i] -> montant;
        }
        
    }

    public function resetMonth()
    {
        $_SESSION['mois']['num'] = (int)date('m');
        $_SESSION['mois']['libelle'] = $this::LISTEMOIS[$_SESSION['mois']['num']];
    }

    const TYPES_FRAIS = ['ETP', 'KM', 'NUI', 'REP'];

    public function isFicheExiste()
    {
        $db = db_connect("auth");

        $id = User::getUserId($_SESSION['login']);

        $sql = "SELECT EXISTS (SELECT * FROM FicheFrais WHERE idVisiteur = ? AND mois = ?) AS 'exist';";
        $resultat = $db -> query($sql, [$id, $_SESSION['mois']['libelle']]);
        $ficheExiste = $resultat -> getResult()[0] -> exist; //on vient voir si la fiche de frais existe

        return $ficheExiste;

    }

    public function changerFrais($frais)
    {
        $db = db_connect("auth");

        $id = User::getUserId($_SESSION['login']);
        $date = date("Y").'-'.date("m").'-'.date("d");

        $ficheExiste = $this -> isFicheExiste();

        $reqFrais = "";
        $req = "";
        if(!$ficheExiste)
        {
            $reqFrais = "INSERT INTO FicheFrais VALUES (?,?,0,0,?,'CR');";
            $req = "INSERT INTO LigneFraisForfait VALUES (?,?,?,?);";
        }
        else
        {
            $reqFrais = "UPDATE FicheFrais SET date = ? WHERE idVisiteur = ? AND mois = ?;";
            $req = "UPDATE LigneFraisForfait SET quantite = ? WHERE idVisiteur = ? AND mois = ? AND idFraisForfait = ?;";
        }

        for($i = 0; $i < 4; $i ++)
        {
            $typeFrais = $this::TYPES_FRAIS[$i];
            if(isset($frais[$typeFrais]))
            {
                if(!$ficheExiste)
                {
                    $db -> query($reqFrais, [
                        $id,
                        $_SESSION['mois']['libelle'],
                        $date
                    ]);
                    $db -> query($req, [
                        $id,
                        $_SESSION['mois']['libelle'],
                        $typeFrais,
                        $frais[$typeFrais]
                    ]);
                }
                else
                {
                    $db -> query($reqFrais, [
                        $date,
                        $id,
                        $_SESSION['mois']['libelle']
                    ]);
                    $db -> query($req, [
                        $frais[$typeFrais],
                        $id,
                        $_SESSION['mois']['libelle'],
                        $typeFrais
                    ]);
                }
            }
        }
    }

    public function envoyerFraisHF($frais)
    {
        $db = db_connect("auth");

        $moisFrais = $this::LISTEMOIS[(int)substr($frais['date'], 5, 2)];
        $id = User::getUserId($_SESSION['login']);
        $date = date("Y") . '-' . date("m") . '-' . date("d");

        $ficheExiste = $this -> isFicheExiste();

        if(!$ficheExiste)
        {
            $reqFiche = "INSERT INTO FicheFrais VALUES ( ?, ?, 0, 0, ?, 'CR');";
            $db -> query($reqFiche, [$id, $_SESSION['mois']['libelle'], $date]);

            $reqLigne = "INSERT INTO LigneFraisForfait VALUES ( ?, ?, ?, ? );";
            for($i = 0; $i < 4; $i ++)
            {
                $typeFrais = $this::TYPES_FRAIS[$i];
                $db -> query($reqLigne, [$id, $_SESSION['mois']['libelle'], $typeFrais, 0]);
            }
        }
        else
        {
            $reqFiche = "UPDATE FicheFrais SET date = ? WHERE idVisiteur = ? AND mois = ?;";
            $db -> query($reqFiche, [$date, $id, $_SESSION['mois']['libelle']]);
        }

        $reqAjoutHF = "INSERT INTO LigneFraisHorsForfait (idVisiteur, mois, libelle, date, montant) VALUES ( ?, ?, ?, ?, ? );";
        $db -> query($reqAjoutHF, [$id, $_SESSION['mois']['libelle'], $frais['libelle'], $frais['date'], $frais['prix']]);
    }
}