<?php

namespace App\Controller;

use App\Enum\Category; // Vérifie le namespace exact de ton Enum Category !
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        Request $request, 
        EventRepository $eventRepository
    ): Response {
        // Récupère la catégorie depuis l'URL (ex: /?category=CONFERENCE)
        $selectedCategory = $request->query->get('category');

        $events = $eventRepository->findUpcomingAndValidated($selectedCategory);

        return $this->render('home/index.html.twig', [
            'events' => $events,
            'categories' => Category::cases(), // Récupère toutes les options de l'enum
            'selectedCategory' => $selectedCategory,
        ]);
    }
    
}