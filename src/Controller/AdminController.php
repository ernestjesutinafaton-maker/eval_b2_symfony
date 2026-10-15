<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_ADMIN')]
final class AdminController extends AbstractController
{


    #[Route('/validate', name: 'app_validate')]
    public function validateList(EventRepository $eventRepository): Response
    {
        $unvalidatedEvents = $eventRepository->findBy(['validated' => false]);

        return $this->render('admin/validate.html.twig', [
            'events' => $unvalidatedEvents,
        ]);
    }

    #[Route('/validate/{id}/approve', name: 'app_validate_approve')]
    public function approve(Event $event, EntityManagerInterface $em): Response
    {
        $event->setValidated(true);
        $em->flush();

        $this->addFlash('success', 'L\'événement a bien été validé.');

        return $this->redirectToRoute('app_validate');
    }
}
    

