<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

final class EventController extends AbstractController
{
    #[Route('/evenement/ajouter', name: 'app_event_new')]
    public function addEvent(    
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('events_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $event->setImage($newFilename);
            }

            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
        }

        return $this->render('event/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/evenement/{id}', name: 'app_event_show', requirements: ['id' => '\d+'])]
public function show(?Event $event): Response
{
    if (!$event) {
        throw $this->createNotFoundException('Cet événement n\'existe pas.');
    }

    return $this->render('event/show.html.twig', [
        'event' => $event,
    ]);
}
#[Route('/evenement/{id}/inscrire', name: 'app_event_subscribe')]
#[IsGranted('ROLE_USER')]
public function subscribe(Event $event, EntityManagerInterface $em): Response
{
    /** @var User $user */
    $user = $this->getUser();

    if ($event->getNombreDePlaces() > 0 && !$event->getUsers()->contains($user)) {
        $event->addUser($user);
        $event->setNombreDePlaces($event->getNombreDePlaces() - 1);

        $em->flush();
    }

    return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
}

#[Route('/evenement/{id}/desinscrire', name: 'app_event_unsubscribe')]
#[IsGranted('ROLE_USER')]
public function unsubscribe(Event $event, EntityManagerInterface $em): Response
{
    /** @var User $user */
    $user = $this->getUser();

    if ($event->getUsers()->contains($user)) {
        $event->removeUser($user);
        $event->setNombreDePlaces($event->getNombreDePlaces() + 1);

        $em->flush();
    }

    return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
}

}