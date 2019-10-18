<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/properties", name="property_index")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {

        $properties= $paginator->paginate($this->repository->findAllVisibleQuery(),
            $request->query->getInt('page', 1),12
        );
        return $this->render('property/index.html.twig', [
            'properties' => $properties,
            'current_menu' => 'properties',
        ]);
    }

    /**
     * @Route("/properties/{slug}-{id}", name="property_show", requirements={"slug": "[a-z0-9\-]*" })
     * @param Property $property
     * @return Response
     */
    public function show(Property $property, string $slug): Response
    {
        if($property->getSlug() != $slug){
            return $this->redirectToRoute('property_show',[
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }
}
