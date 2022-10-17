<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use App\Repository\WeatherRepository;

class WeatherController extends AbstractController
{
	
	##[Route('/weather', name: 'app_weather')]
	public function cityAction(Location $location, WeatherRepository $weatherRepository): Response
	{
		$weatherStatus = $weatherRepository->findByLocation($location);
		
		return $this->render('weather/city.html.twig', [
		'location' => $location,
		'weatherStat' => $weatherStatus,
		]);
	}


	/**public function index(): Response
    *{
    *    return $this->render('weather/index.html.twig', [
    *        'controller_name' => 'WeatherController',
    *    ]);
    }*/
}
