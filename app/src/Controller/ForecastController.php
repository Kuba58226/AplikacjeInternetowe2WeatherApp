<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ForecastType;
use App\Form\ForecastEditType;
use App\Form\ForecastDeleteType;
use App\Entity\City;
use App\Entity\Forecast;
use Symfony\Component\HttpFoundation\Request;

class ForecastController extends AbstractController
{
    public function index(Request $request): Response
    {
        $forecast = new Forecast();
        $form = $this->createForm(ForecastType::class, $forecast);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $forecast = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($forecast);
            $entityManager->flush();
        }

        return $this->render('city/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function edit(Request $request): Response
    {
        $forecast = new Forecast();
        $form = $this->createForm(ForecastEditType::class, $forecast);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $forecast = $this->getDoctrine()->getRepository(Forecast::class)->find($form->getData()->getId());
            $forecast->setDate($form->getData()->getDate());
            $forecast->setTemperature($form->getData()->getTemperature());
            $forecast->setWindSpeed($form->getData()->getWindSpeed());
            $forecast->setHumidity($form->getData()->getHumidity());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($forecast);
            $entityManager->flush();
        }

        return $this->render('city/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function delete(Request $request): Response
    {
        $forecast = new Forecast();
        $form = $this->createForm(ForecastDeleteType::class, $forecast);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $forecast = $this->getDoctrine()->getRepository(Forecast::class)->find($form->getData()->getId());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($forecast);
            $entityManager->flush();
        }

        return $this->render('city/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
