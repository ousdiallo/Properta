<?php

namespace App\Controller;
use App\Repository\PropertyRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


Class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function homepage(PropertyRepository $repository)
    {
        $properties = $repository->findLatest();
        return $this->render('home.html.twig', [
            'properties' => $properties,
        ]);
    }
}