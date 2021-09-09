<?php

namespace App\Controllers;

class Compte extends BaseController
{
    public function connexion($login, $password)
    {
        session_start();
		
        $Modele = new \App\Models\Modele();
        
        $exist = $Modele -> isUserExists(); //on vient voir si l'utilisateur existe
        
        if ( $exist ) { //si l'utilisateur existe
            
            $pass = $Modele -> getUserPassword($login); //on vient chercher le mot de passe de l'utilisateur
            
            if ( $pass == $password ) { //si le mot de passe est bon
                
                $_SESSION['connected'] = TRUE;
                $_SESSION['login'] = $login;

                $names = $Modele -> getUserName($login);
                
                $_SESSION['nom'] = $names['nom'];
                $_SESSION['prenom'] = $name['prenom'];
                
                echo Pages.consulterFrais();
                exit();
                
            } else {
                $_SESSION['error'] = 2;
            }
            
        } else {
            $_SESSION['error'] = 1;
        }

        echo Pages.accueil();
    }

    public function deconnexion()
    {
        session_start();
        session_unset();
    }
}