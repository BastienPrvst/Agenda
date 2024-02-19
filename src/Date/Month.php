<?php

namespace App\Date;

use App\Entity\Date;
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

    public ?int $month;
    public ?int $year;


    /*Suivi du tuto de grafikart.fr afin de voir ce que cela donne avec ma méthode, car je suis bloqué à l'attribution des jours de la semaine par date avec la mienne.
     *
     *
     */

    /**
     * @param int|null $month Le mois entre 1 et 12
     * @param int|null $year
     *
     * Il s'agit de la fonction __construct de l'objet Month avec deux paramètres $month et $year pouvant être null (ce qui affichera le mois et l'année actuelle).
     */
    public function __construct(?int $month = null, ?int $year = null)
    {
        if ($month === null){

            $month = intval(date('m'));

        }

        if ($year === null){

            $year = intval(date('Y'));

        }


//        if ($month < 1 || $month > 12){
//
//            throw new NotFoundHttpException("Le mois $month n'est pas valide");
//
//        }
        if ($year < 1970) {

            throw new NotFoundHttpException("L'année est inférieur à 1970");
        }


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
    public function toString(): string{

       return $this->months[$this->month - 1] . ' ' . $this->year;


    }


    /**
     * @return int Retourne le nombre de semaines dans le mois
     */
    public function getWeeks(): int {


        $start = $this->getFirstDay();
        $end = (clone $start)->modify('+1 month -1 day'); //Permet d'aller au dernier jour du mois


//        $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;
//
//        if ($weeks < 0){
//            $weeks = intval($end->format('W'));
//        }

        $interval = $start->diff($end);
        return ceil(($interval->days + 1) / 7);

     }


     public function withinMonth(\DateTime $date) : bool {

        return $this->getFirstDay()->format('Y-m') === $date->format('Y-m');



     }




}