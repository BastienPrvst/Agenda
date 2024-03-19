<?php

namespace App\Controller;

use App\Entity\CalendarEvent;
use App\Form\CreateEventFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Date\Month;

class MainController extends AbstractController
{

    /**
     * @param int|null $year
     * @return Response
     */
    #[Route('/year{year}', name: 'app_year')]
    public function year(int $year = null): Response
    {

        if ($year === null){

            $year = intval(date('Y'));

        }

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
     * @param $year
     * @param $month
     * @return Response
     */
    #[Route('/{year}/{month}', name: 'app_month', requirements: ["month" => "([1-9]|1[0-2])"])]
    public function agendaMonth($year, $month, ManagerRegistry $doctrine): Response
    {

        //Je passe le mois en int car j'avais une erreur serveur
        $numberMonth = intval($month);

        //Création du nouveau mois (et année) avec celui passé en paramètres + null pour le jour.
        $newMonth = new Month(null,$numberMonth, $year);

        //Passage de la date en string
        $targetedMonth = $newMonth->monthToString();

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


        //On récupere les évenements

        $eventManager = $doctrine->getRepository(CalendarEvent::class);

        $allEvents = $eventManager->findAll();

        dump($allEvents);




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
     * @param $year
     * @param $month
     * @param $day
     * @return Response
     */
    #[Route('/{year}/{month}/{day}', name: 'app_daily')]
    public function agendaDaily($year, $month, $day, ManagerRegistry $doctrine): Response
    {

        $eventManager = $doctrine->getRepository(CalendarEvent::class);

        $allEvents = $eventManager->findAll();

        dump($allEvents);

        $month = new Month($day,$month, $year);

        $dateInString = $month->dayToString();


        return $this->render('main/daily.html.twig', [

            'date' => [
                'day' => $month->day,
                'month' => $month->month,
                'year' => $month->year
            ],
            'dateString' => $dateInString,




        ]);

    }

    /**
     *
     */
    #[Route('/evenement/', name:'app_event')]
    public function createEvent(Request $request, ManagerRegistry $doctrine): Response
    {

        //Création nouvel évent
        $newEvent = new CalendarEvent();

        //Création formulaire
        $eventForm = $this->createForm(CreateEventFormType::class, $newEvent);

        $eventForm->handleRequest($request);


        if ($eventForm->isSubmitted() && $eventForm->isValid()){

            $em = $doctrine->getManager();

            $em->persist($newEvent);

            $em->flush();
            
        }


        return $this->render('main/event.html.twig', [
            'form' => $eventForm->createView(),
        ]);

    }


}
