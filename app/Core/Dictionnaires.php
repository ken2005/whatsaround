<?php
namespace App\Core;

class Dictionnaires {
    private static $mois = [
        'janvier' => 'january',
        'février' => 'february',
        'mars' => 'march',
        'avril' => 'april',
        'mai' => 'may',
        'juin' => 'june',
        'juillet' => 'july',
        'août' => 'august',
        'septembre' => 'september',
        'octobre' => 'october',
        'novembre' => 'november',
        'décembre' => 'december'
    ];

    private static $jours = [
        'lundi' => 'monday',
        'mardi' => 'tuesday',
        'mercredi' => 'wednesday',
        'jeudi' => 'thursday',
        'vendredi' => 'friday',
        'samedi' => 'saturday',
        'dimanche' => 'sunday'
    ];

    public static function getMois($key = null) {
        if ($key !== null) {
            return isset(self::$mois[$key]) ? self::$mois[$key] : null;
        }
        return self::$mois;
    }

    public static function getJours($key = null) {
        if ($key !== null) {
            return isset(self::$jours[$key]) ? self::$jours[$key] : null;
        }
        return self::$jours;
    }

    public static function getMoisFrancais() {
        return array_keys(self::$mois);
    }

    public static function getMoisAnglais() {
        return array_values(self::$mois);
    }

    public static function getJoursFrancais() {
        return array_keys(self::$jours);
    }

    public static function getJoursAnglais() {
        return array_values(self::$jours);
    }
}
