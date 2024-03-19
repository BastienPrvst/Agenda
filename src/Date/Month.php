<?php

namespace App\Date;

use App\Entity\Date;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class Month {

    public array $days = [
        'Lundi',
        'Mardi',
        'Mercredi',
        'Jeudi',
        'Vendredi',
        'Samedi',
        'Dimanche'
    ];

    //Array des noms des mois
    private array $months = [
        'Janvier',
        'Février',
        'Mars',
        'Avril',
        'Mai',
        'Juin',
        'Juillet',
        'Août',
        'Septembre',
        'Octobre',
        'Novembre',
        'Décembre'
    ];

    public ?int $day;
    public ?int $month;
    public ?int $year;


    /**
     * @param int|null $month Le mois entre 1 et 12
     * @param int|null $year
     *
     * Il s'agit de la fonction __construct de l'objet Month avec deux paramètres $month et $year pouvant être null (ce qui affichera le mois et l'année actuelle).
     */
    public function __construct(?int $day = null, ?int $month = null, ?int $year = null)
    {
        if ($month === null){

            $month = intval(date('m'));

        }


        if (isset($day)){

            if ($day < 1 || $day > 31){

                throw new NotFoundHttpException("Le jour $day n/'est pas valide");

            }

        }





        if ($month < 1 || $month > 12){

            throw new NotFoundHttpException("Le mois $month n'est pas valide");

        }
        if ($year < 1970) {

            throw new NotFoundHttpException("L'année est inférieur à 1970");
        }

        $this->day = $day;
        $this->month = $month;
        $this->year = $year;

    }

    /**
     * Renvoie le premier jour du mois
     * @return \DateTime
     */
    public function getFirstDay(): \DateTime {

    return new \DateTime("$this->year-$this->month-01");

    }


    /**
     * @return string Retourne le mois en toutes lettres
     */
    public function monthToString(): string{

       return $this->months[$this->month - 1] . ' ' . $this->year;

    }

    public function dayToString(): string{

        $date = new \DateTime("$this->year-$this->month-$this->day");

        $dayNumber = $date->format('d');

        $dayName = $this->days[$date->format('N') -1];

        return $dayName . ' ' . $dayNumber . ' ' . $this->months[$this->month - 1] . ' ' . $this->year;

    }

    /**
     * @return int Retourne le nombre de semaines dans le mois
     */
    public function getWeeks(): int {

        $start = $this->getFirstDay();

        $end = (clone $start)->modify('+1 month -1 day');

        //Méthode pour les mois commencant un lundi qui prenaient toute la semaine précédente

        if ($start->format('N') !== '1'){

            $start->modify('last monday');

        }

        $interval = $start->diff($end);
        return ceil(($interval->days + 1) / 7);

     }





}