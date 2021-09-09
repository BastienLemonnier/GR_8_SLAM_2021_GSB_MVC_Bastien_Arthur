<?php

namespace App\Models;

class Frais
{

    public function getFraisMoisChoisis()
    {
        $db = db_connect("guest");

        $sql = "SELECT quantite FROM LigneFraisForfait INNER JOIN FraisForfait ON LigneFraisForfait.idFraisForfait = FraisForfait.id
        WHERE idVisiteur = ? AND mois LIKE ? ORDER BY FraisForfait.id;";
        $resultat = $db -> query($id, $moisChoisis);
        $resultat = $resultat -> getResult();

        if(empty($resultat))
        {
            for($i = 0; $i < 4; $i ++)
            {
                $resultat[$i] = 0;
            }
        }

        return $resultat;
    }

}