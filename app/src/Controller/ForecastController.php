<?php

namespace App\Controller;

use App\Entity\Forecast;
use App\Form\ForecastType;
use App\Repository\ForecastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/forecast")
 */
class ForecastController extends AbstractController
{
    /**
     * @Route("/", name="forecast_index", methods={"GET"})
     */
    public function index(ForecastRepository $forecastRepository): Response
    {
        return $this->render('forecast/index.html.twig', [
            'forecasts' => $forecastRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="forecast_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $forecast = new Forecast();
        $form = $this->createForm(ForecastType::class, $forecast);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($forecast);
            $entityManager->flush();

            return $this->redirectToRoute('forecast_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('forecast/new.html.twig', [
            'forecast' => $forecast,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="forecast_show", methods={"GET"})
     */
    public function show(Forecast $forecast): Response
    {
        return $this->render('forecast/show.html.twig', [
            'forecast' => $forecast,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="forecast_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Forecast $forecast): Response
    {
        $form = $this->createForm(ForecastType::class, $forecast);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('forecast_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('forecast/edit.html.twig', [
            'forecast' => $forecast,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="forecast_delete", methods={"POST"})
     */
    public function delete(Request $request, Forecast $forecast): Response
    {
        if ($this->isCsrfTokenValid('delete'.$forecast->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($forecast);
            $entityManager->flush();
        }

        return $this->redirectToRoute('forecast_index', [], Response::HTTP_SEE_OTHER);
    }
}
