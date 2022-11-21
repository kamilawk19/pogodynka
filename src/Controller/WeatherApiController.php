<?php

namespace App\Controller;

use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class WeatherApiController extends AbstractController
{
    #[Route('/weather/api/api_twig.{ext}', name: 'app_weather_api_ext')]
    public function WeatherPayloadAction(Request $request, WeatherUtil $wUtil, $ext): Response
    {
        $payload=$request->getContent();
        $payload=json_decode($payload,true);
        $city=$payload['city'] ?? null;
        $country=$payload['country'] ?? null;

        if(!$city || !$country){
            throw new BadRequestException('Param missing!!!');
        }

        $loc=$wUtil->getWeatherForCountryAndCity($country,$city);

        if(!$loc){
            throw new BadRequestException('Bad request!!!');
        }

        $ret=$this->render("weather_api/api_twig.{$ext}.twig",[
            'country' => $country,
            'city' => $city,
            'w' => $loc
        ]);

        if($ext=='json'){
            $ret->headers->set('Content-Type', 'application/json');
        }elseif($ext=='csv'){
            $ret->headers->set('Content-Type', 'text/csv');
        }

        return $ret;
    }
   /* #[Route('/weather/api/api.json', name: 'app_weather_api_json')]
    public function WeatherPayloadAction(Request $request, WeatherUtil $wUtil): JsonResponse
    {
        $payload=$request->getContent();
        $payload=json_decode($payload,true);
        $city=$payload['city'] ?? null;
        $country=$payload['country'] ?? null;

        if(!$city || !$country){
            throw new BadRequestException('Param missing!!!');
        }

        $loc=$wUtil->getWeatherForCountryAndCity($country,$city);

        if(!$loc){
            throw new BadRequestException('Bad request!!!');
        }
        $res=[
            'Country' => $country,
            'City' => $city,
            'Weather' => []
        ];

        foreach ($loc as $w){
            $res['Weather'][]=[
                'temp_max' => $w->getTempMax(),
                'temp_min' => $w->getTempMin(),
                'temp_avg' => $w->getTempAvg(),
                'weather_name' => $w->getWeatherName(),
                'weather_description' => $w->getWeatherDescription(),
            ];
        }

        return new JsonResponse($res);
    }

    #[Route('/weather/api-csv/api.csv', name: 'app_weather_api_csv')]
    public function WeatherPayloadActionCSV(Request $request, WeatherUtil $wUtil): Response
    {
        $payload=$request->getContent();
        $payload=json_decode($payload,true);
        $city=$payload['city'] ?? null;
        $country=$payload['country'] ?? null;

        if(!$city || !$country){
            throw new BadRequestException('Param missing!!!');
        }

        $loc=$wUtil->getWeatherForCountryAndCity($country,$city);

        if(!$loc){
            throw new BadRequestException('Bad request!!!');
        }

        $head=[
            'Country',
            'City',
            'temp_max',
            'temp_min',
            'temp_avg',
            'weather_name',
            'weather_description'
        ];

        $head=implode(",",$head)."\n";
        $csv="";

        foreach ($loc as $w){
            $t=[
                $country,
                $city,
                $w->getTempMax(),
                $w->getTempMin(),
                $w->getTempAvg(),
                $w->getWeatherName(),
                $w->getWeatherDescription(),
            ];
            $t=implode(",",$t)."\n";
            $csv=$t;
        }
        $res=$head.$csv;

        $response=new Response();
        $response->setContent($res);
        $response->headers->set('Content-Type', 'text/csv');

        return $response;
    }*/
}
