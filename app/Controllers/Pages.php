<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        //décision de l'action à effectuer selon les données recues
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
        //changement frais
        if(isset($_POST['nombre_etapes']) || isset($_POST['nombre_km']) || isset($_POST['nombre_nuitee']) || isset($_POST['nombre_repas']))
        {
            $action = 'changerFrais';
            if(isset($_POST['nombre_etapes'])) {
                $frais['ETP'] = $_POST['nombre_etapes'];
            } else {
                $frais['ETP'] = NULL;
            }
            if(isset($_POST['nombre_km'])) {
                $frais['KM'] = $_POST['nombre_km'];
            } else {
                $frais['KM'] = NULL;
            }
            if(isset($_POST['nombre_nuitee'])) {
                $frais['NUI'] = $_POST['nombre_nuitee'];
            } else {
                $frais['NUI'] = NULL;
            }
            if(isset($_POST['nombre_repas'])) {
                $frais['REP'] = $_POST['nombre_repas'];
            } else {
                $frais['REP'] = NULL;
            }
        }
        //ajout frais HF
        if(isset($_POST['libelle_frais']) && isset($_POST['date_frais']) && isset($_POST['prix_frais']))
        {
            $action = 'ajouterFraisHF';
            $frais['libelle'] = strip_tags($_POST['libelle_frais']);
            $frais['date'] = $_POST['date_frais'];
            $frais['prix'] = $_POST['prix_frais'];
        }
        //consultation frais
        $month = (int)date('m');
        if(isset($_POST['month_select']))
        {
            $action = 'consulterFrais';
            $month = $_POST['month_select'];
        }

        //connexion ou redirection vers l'accueil si non connecté
        if(isset($_POST['connexion_login']) && isset($_POST['connexion_password']))
        {
            $action = 'connexion';
            $login = $_POST['connexion_login'];
            $password = $_POST['connexion_password'];
        }
        else
        if(!isset($_SESSION['connected']) || !$_SESSION['connected'])
        {
            $action = 'accueil';
        }

        //appel de fonctions selon l'action
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
            case 'default' :
            case 'accueil' :
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
