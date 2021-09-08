<?php

namespace App\Models;

class Modele extends Model
{
    const LISTEMOIS = [ 1 => "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"];

    private $db;
    const DBHOST = "mysql:host=localhost; dbname=GSBV2; charset=utf8;";

    public function initDatabase()
    {
        if(!isset($db['guest']))
        {
            $db['guest']['dsn'] = DBHOST;
            $db['guest']['username'] = "guestUser";
            $db['guest']['password'] = 'GSBmdp';
            $db['guest']['dbdriver'] = "pdo";
        }

        if(!isset($db['auth']))
        {
            $db['auth']['dsn'] = DBHOST;
            $db['auth']['username'] = "authUser";
            $db['auth']['password'] = 'GSBmdp';
            $db['auth']['dbdriver'] = "pdo";
        }
    }

    public function recupMois($numMois)
    {
        if( isset($_GET['month']) ) {
            $moisChoisi = $_GET['month'];
        } else {
            $moisChoisi = (int)date('m');
        }
    }
}