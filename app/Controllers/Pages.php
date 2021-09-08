<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $action = 'default';
        if(isset($_POST['connexion_login']) && isset($_POST['connexion_password']))
        {
            $action = 'connexion';
            $login = $_POST['connexion_login'];
            $password = $_POST['connexion_password'];
        }

        switch($action)
        {
            case 'connexion' :
                $this -> consulterFrais();
                break;
            default :
                $this -> accueil();
                break;
            
        }
        
    }

    public function accueil()
    {
        echo view('accueil');
    }
	
	public function consulterFrais()
	{
		echo view('consulterFrais');
	}

    public function saisirFrais()
    {
        echo view('SaisirFrais');
    }
}
