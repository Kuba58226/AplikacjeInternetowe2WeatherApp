<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CityType;
use App\Form\CityEditType;
use App\Form\CityDeleteType;
use App\Entity\City;
use App\Entity\Forecast;
use Symfony\Component\HttpFoundation\Request;

class CityController extends AbstractController
{
    public function index(Request $request): Response
    {
        $city = new City();
        $form = $this->createForm(CityType::class, $city);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $city = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($city);
            $entityManager->flush();
        }


        return $this->render('city/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function edit(Request $request): Response
    {
        $city = new City();
        $form = $this->createForm(CityEditType::class, $city);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $city = $this->getDoctrine()->getRepository(City::class)->find($form->getData()->getId());
            $city->setName($form->getData()->getName());
            $city->setLongitude($form->getData()->getLongitude());
            $city->setLatitude($form->getData()->getLatitude());
            $city->setCountry($form->getData()->getCountry());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($city);
            $entityManager->flush();
        }

        return $this->render('city/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function delete(Request $request): Response
    {
        $city = new City();
        $form = $this->createForm(CityDeleteType::class, $city);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $city = $this->getDoctrine()->getRepository(City::class)->find($form->getData()->getId());

            $forecasts = $this->getDoctrine()->getRepository(Forecast::class)->findBy([
                'city' => $city
            ]);

            $entityManager = $this->getDoctrine()->getManager();
            foreach ($forecasts as $forecast) {
                $entityManager->remove($forecast);
            }
            $entityManager->remove($city);
            $entityManager->flush();
        }

        return $this->render('city/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
