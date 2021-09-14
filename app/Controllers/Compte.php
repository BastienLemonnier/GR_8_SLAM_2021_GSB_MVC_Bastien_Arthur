<?php

namespace App\Controllers;

class Compte extends BaseController
{
    public function connexion($login, $password)
    {
        session_start();
		
        $Modele = new \App\Models\Modele();
        $Pages = new \App\Controllers\Pages();
        
        $exist = $Modele -> isUserExists($login); //on vient voir si l'utilisateur existe
        
        if ( $exist ) { //si l'utilisateur existe
            
            $pass = $Modele -> getUserPassword($login); //on vient chercher le mot de passe de l'utilisateur
            //print_r($pass[0] -> mdp);
            
            if ( $pass == $password ) { //si le mot de passe est bon
                
                $_SESSION['connected'] = TRUE;
                $_SESSION['login'] = $login;

                $name = $Modele -> getUserName($login);
                
                $_SESSION['nom'] = $name['nom'];
                $_SESSION['prenom'] = $name['prenom'];
                
                echo $Pages -> consulterFrais((int)date('m'));
                exit();
                
            } else {
                $_SESSION['error'] = 2;
            }
            
        } else {
            $_SESSION['error'] = 1;
        }

        echo $Pages -> accueil();
    }

    public function deconnexion()
    {
        session_start();
        session_unset();
    }
}