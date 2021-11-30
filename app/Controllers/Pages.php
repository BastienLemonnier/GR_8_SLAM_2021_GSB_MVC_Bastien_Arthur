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
            $action = strip_tags($_GET['action']);
        }
        $isAjax = false;
        if(isset($_GET['mode']))
        {
            $mode = strip_tags($_GET['mode']);
            if($mode == 'ajax')
            {
                $isAjax = true;
            }
        }

        $token = "";
        if(isset($_GET['token']))
        {
            $token = $_GET['token'];
        }
        else if(isset($_POST['token']))
        {
            $token = $_POST['token'];
        }

        $infos = [];
        $infos['month'] = (int)date('m');
        if(isset($_SESSION['token']) && $token == $_SESSION['token'])
        {
            //changement frais
            if(isset($_POST['nombre_etapes']) || isset($_POST['nombre_km']) || isset($_POST['nombre_nuitee']) || isset($_POST['nombre_repas']))
            {
                $action = 'changerFrais';
                if(isset($_POST['nombre_etapes'])) {
                    $infos['frais']['ETP'] = strip_tags($_POST['nombre_etapes']);
                } else {
                    $infos['frais']['ETP'] = NULL;
                }
                if(isset($_POST['nombre_km'])) {
                    $infos['frais']['KM'] = strip_tags($_POST['nombre_km']);
                } else {
                    $infos['frais']['KM'] = NULL;
                }
                if(isset($_POST['nombre_nuitee'])) {
                    $infos['frais']['NUI'] = strip_tags($_POST['nombre_nuitee']);
                } else {
                    $infos['frais']['NUI'] = NULL;
                }
                if(isset($_POST['nombre_repas'])) {
                    $infos['frais']['REP'] = strip_tags($_POST['nombre_repas']);
                } else {
                    $infos['frais']['REP'] = NULL;
                }
            }

            //ajout frais HF
            if(isset($_POST['libelle_frais']) && isset($_POST['date_frais']) && isset($_POST['prix_frais']))
            {
                $action = 'ajouterFraisHF';
                $infos['frais']['libelle'] = strip_tags($_POST['libelle_frais']);
                $infos['frais']['date'] = strip_tags($_POST['date_frais']);
                $infos['frais']['prix'] = strip_tags($_POST['prix_frais']);
            }

            //consultation frais
            if(isset($_POST['month_select']))
            {
                $action = 'consulterFrais';
                $infos['month'] = strip_tags($_POST['month_select']);
            }
            if(isset($_GET['mois']))
            {
                $infos['month'] = strip_tags($_GET['mois']);
            }

            //connexion ou redirection vers l'accueil si non connecté
            if(isset($_POST['connexion_login']) && isset($_POST['connexion_password']))
            {
                $action = 'connexion';
                $infos['login'] = strip_tags($_POST['connexion_login']);
                $infos['password'] = strip_tags($_POST['connexion_password']);
            }
            else
            if(!isset($_SESSION['connected']) || !$_SESSION['connected'])
            {
                $action = 'accueil';
            }
        }
        if(!$isAjax)
            $_SESSION['token'] = bin2hex(random_bytes(32));

        if(!isset($_COOKIE['ticket']) || !isset($_SESSION['ticket']))
        {
            $ticket = session_id().microtime().rand(0,9999999999);
            $ticket = hash('sha512', $ticket);
            setcookie('ticket', $ticket, time() +  (60 * 20));
        }
        else
        {
            if($_COOKIE['ticket'] == $_SESSION['ticket'])
            {
                $ticket = session_id().microtime().rand(0,9999999999);
                $ticket = hash('sha512', $ticket);
                $_COOKIE['ticket'] = $ticket;
                $_SESSION['ticket'] = $ticket;
            }
            else
            {
                $action = 'default';
                $_SESSION = array();
                $_COOKIE = array();
                session_destroy();
            }
        }

        //appel de fonctions selon l'action
        switch($action)
        {
            case 'consulterFrais' :
                $this -> consulterFrais($infos['month']);
                break;
            case 'saisirFrais' :
                $this -> saisirFrais();
                break;
            case 'changerFrais' :
                $this -> changerFrais($infos['frais'], $isAjax);
                break;
            case 'ajouterFraisHF' :
                $this -> ajouterFraisHF($infos['frais'], $isAjax);
                break;
            case 'getFraisMois' :
                $this -> getFraisMois($infos['month']);
                break;
            case 'connexion' :
                $this -> connexion($infos['login'], $infos['password']);
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

    public function securiseInclude($page)
    {
        if(empty($page))
        {
            $page = "accueil";
        }
        // On limite l'inclusion aux fichiers.php en ajoutant dynamiquement l'extension
        // On supprime également d'éventuels espaces
        $page = trim($page . ".php");
        // On évite les caractères qui permettent de naviguer dans les répertoires
        $page = str_replace("../", "protect", $page);
        $page = str_replace(";", "protect", $page);
        $page = str_replace("%", "protect", $page);
        // On interdit l'inclusion de dossiers protégés par htaccess
        if(preg_match("admin", $page))
        {
            echo "Vous n'avez pas accès à ce répertoire";
        }
        else
        {
        // On vérifie que la page est bien sur le serveur
            if(file_exists($page) && $page != 'index.php')
            {
                include("./" . $page);
            }
            else
            {
                echo "Page inexistante !";
            }
        }
    }
}
