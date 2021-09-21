<?php

namespace App\Controllers;

class Compte extends BaseController
{
    public function connexion($login, $password)
    {
        $User = new \App\Models\User();
        $Pages = new \App\Controllers\Pages();

        unset($_SESSION['error']);
        
        $exist = $User::isUserExists($login); //on vient voir si l'utilisateur existe
        
        if ( $exist ) { //si l'utilisateur existe
            
            $pass = $User::getUserPassword($login); //on vient chercher le mot de passe de l'utilisateur
            
            if ( $pass == $password ) { //si le mot de passe est bon
                
                $_SESSION['connected'] = TRUE;
                $_SESSION['login'] = $login;

                $name = $User::getUserName($login);
                
                $_SESSION['nom'] = $name['nom'];
                $_SESSION['prenom'] = $name['prenom'];
                
                $Pages -> consulterFrais((int)date('m'));
                exit();
                
            } else {
                $_SESSION['error'] = "Mot de passe erroné.";
            }
            
        } else {
            $_SESSION['error'] = "Cet utilisateur n'existe pas.";
        }

        $Pages -> accueil();
    }

    public function deconnexion()
    {
        session_unset();
    }
}