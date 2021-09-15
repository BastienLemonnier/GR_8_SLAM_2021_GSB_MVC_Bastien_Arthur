<?php

namespace App\Controllers;

class Compte extends BaseController
{
    public function connexion($login, $password)
    {
        $User = new \App\Models\User();
        $Pages = new \App\Controllers\Pages();
        
        $exist = $User::isUserExists($login); //on vient voir si l'utilisateur existe
        
        if ( $exist ) { //si l'utilisateur existe
            
            $pass = $User::getUserPassword($login); //on vient chercher le mot de passe de l'utilisateur
            
            if ( $pass == $password ) { //si le mot de passe est bon
                
                $_SESSION['connected'] = TRUE;
                $_SESSION['login'] = $login;

                $name = $User::getUserName($login);
                
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
        session_unset();
    }
}