<?php

namespace App\Controller;

use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Date\Month;

class MainController extends AbstractController
{


    #[Route('/', name: 'app_main')]
    public function index(Month $month): Response
    {

        $newMonth = new Month();

        dump($newMonth);
        dump($newMonth->toString());

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
//            'monthDay'=> $monthDay,
            'monthsNumberName' => $monthNumberName

        ]);
    }

    #[Route('/{month}', name: 'app_agenda')]
    public function agenda($month): Response
    {

        $newMonth = new Month($month);

        $targetedMonth = $newMonth->toString();


        $numberOfWeeks = $newMonth->getWeeks();


        dump($numberOfWeeks);




        $daysOfMonth = cal_days_in_month(CAL_GREGORIAN, $month, 2024);
//
//        dump($daysOfMonth);
//
//        $numberOfDaysInMonth = [];
//
//        for ($i = 0; $i <=$daysOfMonth; $i++){
//
//            $numberOfDaysInMonth[] = 'day';
//
//        }
//
//
//        dump($numberOfDaysInMonth);



        return $this->render('main/agenda.html.twig', [

            'numberOfDays' => $daysOfMonth,
            'monthName' => $targetedMonth,


        ]);



    }


}
