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
        if(isset($_POST['']))
        {

        }

        switch($action)
        {
            case 'consulterFrais' :
                $this -> consulterFrais();
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
        $Compte = new \App\Models\Compte();

        $Compte -> connexion($login, $password);

        $this -> consulterFrais();
    }
	
	public function consulterFrais()
	{
        $Modele = new \App\Models\Modele();

        $Modele -> getFraisMoisChoisis();

		echo view('consulterFrais');
	}

    public function saisirFrais()
    {
        echo view('SaisirFrais');
    }
}
