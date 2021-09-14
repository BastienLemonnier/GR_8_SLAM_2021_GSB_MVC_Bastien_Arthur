<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $action = 'default';
        if(isset($_GET['action']))
        {
            $action = $_GET['action'];
        }
        if(isset($_POST['connexion_login']) && isset($_POST['connexion_password']))
        {
            $action = 'connexion';
            $login = $_POST['connexion_login'];
            $password = $_POST['connexion_password'];
        }
        $month = (int)date('m');
        if(isset($_POST['month_select']))
        {
            $action = 'consulterFrais';
            $month = $_POST['month_select'];
        }

        switch($action)
        {
            case 'consulterFrais' :
                $this -> consulterFrais($month);
                break;
            case 'saisirFrais' :
                $this -> saisirFrais();
                break;
            case 'connexion' :
                $this -> connexion($login, $password);
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

    public function connexion($login, $password)
    {
        $Compte = new \App\Controllers\Compte();

        $Compte -> connexion($login, $password);
        $month = (int)date('m');

        $this -> consulterFrais($month);
    }
	
	public function consulterFrais($month)
	{
        $Modele = new \App\Models\Modele();

        //$Modele -> getFraisMoisChoisis($month);

		echo view('consulterFrais');
	}

    public function saisirFrais()
    {
        echo view('SaisirFrais');
    }
}
