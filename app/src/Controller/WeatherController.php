<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ForecastRepository;
use App\Repository\CityRepository;

class WeatherController extends AbstractController
{
    /** @var ForecastRepository $forecastRepository */
    private $forecastRepository;

    /** @var CityRepository $cityRepository */
    private $cityRepository;

    public function __construct(
        ForecastRepository $forecastRepository,
        CityRepository $cityRepository
    ) {
        $this->forecastRepository = $forecastRepository;
        $this->cityRepository = $cityRepository;
    }

    public function cityAction($city, $country): Response
    {
        $city = $this->cityRepository->findByCityCountry($city, $country);
        $forecasts = $this->forecastRepository->findByCity($city[0]);

        return $this->render('weather/index.html.twig', [
            'controller_name' => 'WeatherController',
            'city' => $city[0],
            'forecasts' => $forecasts,
        ]);
    }
}
