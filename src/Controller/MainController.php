<?php

namespace App\Controller;

use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Date\Month;

class MainController extends AbstractController
{

    /**
     * @param int|null $year
     * @return Response
     */
    #[Route('/{year}', name: 'app_year')]
    public function year(?int $year = null): Response
    {

        if ($year === null){

            $year = intval(date('Y'));

        }

        dump($year);

        $monthsName = [
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

        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

        $monthNumberName = array_combine($months, $monthsName);


        return $this->render('main/index.html.twig', [

            'monthsName' => $monthsName,
            'months' => $months,
            'monthsNumberName' => $monthNumberName,
            'year' => $year

        ]);
    }

    /**
     * @param $month
     * @return Response
     */
    #[Route('/{year}/{month}', name: 'app_month', requirements: ["month" => "([1-9]|1[0-2])"])]
    public function agendaMonth($year, $month): Response
    {

        //Je passe le mois en int car j'avais une erreur serveur
        $numberMonth = intval($month);

        //Création du nouveau mois avec celui passé en paramètres
        $newMonth = new Month($numberMonth, $year);

        //Passage du mois en string
        $targetedMonth = $newMonth->toString();

        //Nombre de semaines dans le mois
        $numberOfWeeks = $newMonth->getWeeks();

        $days = $newMonth->days;

        //On récupere le mois actuel
        $actualMonth = $newMonth->month;

        //On récupère le dernier lundi par rapport au premier jour du mois


//        Condition pour des cas comme janvier ou il prenait la derniere semaine de décembre
        if($newMonth->getFirstDay()->format('N') === '1'){

            $firstMonday = $newMonth->getFirstDay();

        }else{

            $firstMonday = $newMonth->getFirstDay()->modify('last monday');

        }


        $firstDay = $newMonth->getFirstDay();



        return $this->render('main/agenda.html.twig', [

            'monthName' => $targetedMonth,
            'numberOfWeeks' => $numberOfWeeks,
            'days' => $days,
            'firstMonday'=> $firstMonday,
            'actualMonth' => $actualMonth,
            'firstDay' => $firstDay,
            'month' => $numberMonth,
            'year' => $year

        ]);



    }


    /**
     * @param $month
     * @param $day
     * @return Response
     */
    #[Route('/{month}/{day}', name: 'app_daily')]
    public function agendaDaily($month, $day): Response
    {

        $month = new Month();





        return $this->render('main/daily.html.twig');

    }

}
