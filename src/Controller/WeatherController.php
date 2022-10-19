<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use App\Repository\WeatherRepository;
use App\Repository\LocationRepository;

class WeatherController extends AbstractController
{
	
	##[Route('/weather/{locationId}', name: 'weather_in_city')]
	public function cityAction( $locationId, WeatherRepository $weatherRepository, LocationRepository $locationRepository): Response
	{
		$location=$locationRepository->find($locationId);
		$weatherStatus = $weatherRepository->findByLocation($location);
		
		return $this->render('weather/city.html.twig', [
		'location' => $location,
		'weatherStat' => $weatherStatus,
		]);
	}

	##[Route('/weather/{country}/{city}', name: 'weather_country_city')]
	public function countrycityAction( $country, $city, WeatherRepository $weatherRepository, LocationRepository $locationRepository): Response
	{
		$wt=$locationRepository->findBy([
			"country" => $country,
			"city" => $city
		])[0]->getWeather()->getValues();
		
		return $this->render('weather/country_and_city.html.twig', [
		'weatherStat' => $wt,
		'country' => $country,
		'city' => $city
		]);
	}


	/**public function index(): Response
    *{
    *    return $this->render('weather/index.html.twig', [
    *        'controller_name' => 'WeatherController',
    *    ]);
    }*/
}
