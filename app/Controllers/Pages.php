<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        session_start();
        $action = 'default';
        if(isset($_GET['action']))
        {
            $action = $_GET['action'];
        }
        if(isset($_GET['mois']))
        {
            $mois = $_GET['mois'];
        }
        $isAjax = false;
        if(isset($_GET['mode']))
        {
            $mode = $_GET['mode'];
            if($mode == 'ajax')
            {
                $isAjax = true;
            }
        }
        if(isset($_POST['connexion_login']) && isset($_POST['connexion_password']))
        {
            $action = 'connexion';
            $login = $_POST['connexion_login'];
            $password = $_POST['connexion_password'];
        }
        if(isset($_POST['nombre_etapes']) || isset($_POST['nombre_km']) || isset($_POST['nombre_nuitee']) || isset($_POST['nombre_repas']))
        {
            $action = 'changerFrais';
            if(isset($_POST['nombre_etapes']))
                $frais['ETP'] = $_POST['nombre_etapes'];
            if(isset($_POST['nombre_km']))
                $frais['KM'] = $_POST['nombre_km'];
            if(isset($_POST['nombre_nuitee']))
                $frais['NUI'] = $_POST['nombre_nuitee'];
            if(isset($_POST['nombre_repas']))
                $frais['REP'] = $_POST['nombre_repas'];
        }
        if(isset($_POST['libelle_frais']) && isset($_POST['date_frais']) && isset($_POST['prix_frais']))
        {
            $action = 'ajouterFraisHF';
            $frais['libelle'] = strip_tags($_POST['libelle_frais']);
            $frais['date'] = $_POST['date_frais'];
            $frais['prix'] = $_POST['prix_frais'];
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
            case 'changerFrais' :
                $this -> changerFrais($frais, $isAjax);
                break;
            case 'ajouterFraisHF' :
                $this -> ajouterFraisHF($frais, $isAjax);
                break;
            case 'getFraisMois' :
                $this -> getFraisMois($mois);
                break;
            case 'connexion' :
                $this -> connexion($login, $password);
                break;
            case 'deconnexion' :
                $this -> deconnexion();
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

    public function deconnexion()
    {
        $Compte = new \App\Controllers\Compte();

        $Compte -> deconnexion();

        $this -> accueil();
    }

	public function consulterFrais($month)
	{
        $Modele = new \App\Models\Modele();

        $Modele -> getFraisMoisChoisis($month);

		echo view('consulterFrais');
	}

    public function saisirFrais()
    {
        $Modele = new \App\Models\Modele();

        $Modele -> resetMonth();
        $Modele -> getFraisMoisChoisis($_SESSION['mois']['num']);

        echo view('SaisirFrais');
    }

    public function changerFrais($frais, $isAjax)
    {
        $Modele = new \App\Models\Modele();

        $Modele -> changerFrais($frais);

        if(!$isAjax)
        {
            $this -> saisirFrais();
        }
    }

    public function getFraisMois($mois)
    {
        $Modele = new \App\Models\Modele();

        $Modele -> getFraisMoisChoisis($mois);

		echo view('sectionFraisMois');
    }

    public function ajouterFraisHF($frais, $isAjax)
    {
        $Modele = new \App\Models\Modele();

        $Modele -> envoyerFraisHF($frais);

        if(!$isAjax)
        {
            $this -> saisirFrais();
        }
    }
}
