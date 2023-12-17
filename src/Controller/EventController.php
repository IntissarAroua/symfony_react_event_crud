<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Event;
use App\Form\EventType;
use App\Service\EventService;

use \Datetime;

#[Route('/api/event', name: 'event_')]
class EventController extends AbstractController
{
    private $EventService;

    public function __construct(EventService $EventService)
    {
        $this->EventService = $EventService;
    }

    #[OA\Response(
        response: 200,
        description: 'Returns list of all events',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Event::class))
        )
    )]
    #[OA\Tag(name: 'Event')]
    #[Route('', name: '_list', methods: ['GET'])]
    public function index()
    {
        $list = $this->EventService->getEvent();

        $jsonEvent = [];
        foreach ($list as $key => $event) {
            $jsonEvent[$key] = $this->EventService->toJson($event);
        }

        return new JsonResponse($jsonEvent);
    }

    #[OA\Response(
        response: 200,
        description: 'Returns event by id',
        content: new OA\JsonContent(ref: new Model(type: Event::class))
    )]
    #[OA\Tag(name: 'Event')]
    #[Route('/{id}/detail', name: '_detail', methods: ['GET'])]
    public function getEvent($id)
    {
        $event = $this->EventService->get($id);
        $jsonEvent = $this->EventService->toJson($event);

        return new JsonResponse($jsonEvent);
    }

    #[OA\Response(
        response: 200,
        description: 'Returns list of events by date and location',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Event::class))
        )
    )]
    #[OA\Parameter(
        name: 'date',
        in: 'query',
        description: 'Date',
        schema: new OA\Schema(type: 'datetime')
    )]
    #[OA\Parameter(
        name: 'location',
        in: 'query',
        description: 'Location',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'Event')]
    #[Route('/filter', name: '_filter', methods: ['POST'])]
    public function getEventByDateAndLocation(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $list = $this->EventService->getEventByDateAndLocation($data['date'], $data['location']);
        $jsonEvent = [];
        foreach ($list as $key => $event) {
            $jsonEvent[$key] = $this->EventService->toJson($event);
        }

        return new JsonResponse($jsonEvent);
    }

    #[OA\Response(
        response: 200,
        description: 'Creates a new event object',
        content: new OA\JsonContent(ref: new Model(type: Event::class))
    )]
    #[OA\Response(
        response: 300,
        description: 'Invalid formType',
    )]
    #[OA\Response(
        response: 400,
        description: 'Bad request',
    )]
    #[OA\Parameter(
        name: 'title',
        in: 'query',
        description: 'The title of the event',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'description',
        in: 'query',
        description: 'The description of the event',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'start_date',
        in: 'query',
        description: 'the start date of the event',
        schema: new OA\Schema(type: 'datetime')
    )]
    #[OA\Parameter(
        name: 'end_date',
        in: 'query',
        description: 'the end date of the event',
        schema: new OA\Schema(type: 'datetime')
    )]
    #[OA\Parameter(
        name: 'location',
        in: 'query',
        description: 'the location of the event',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'Event')]
    #[Route('/add', name: '_add', methods: ['POST'])]
    public function createEvent(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $event = new Event();
        $form = $this->createForm(EventType::class, $event, array('csrf_protection' => false));
        $form->submit($data);

        $event->setStartDate(new DateTime($data['start_date']));
        $event->setEndDate(new DateTime($data['end_date']));

        $event = $this->EventService->persist($event);
        return new JsonResponse($data);
    }

    #[OA\Response(
        response: 200,
        description: 'Updates an event object',
        content: new OA\JsonContent(ref: new Model(type: Event::class))
    )]
    #[OA\Parameter(
        name: 'title',
        in: 'query',
        description: 'The title of the event',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'description',
        in: 'query',
        description: 'The description of the event',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'start_date',
        in: 'query',
        description: 'the start date of the event',
        schema: new OA\Schema(type: 'datetime')
    )]
    #[OA\Parameter(
        name: 'end_date',
        in: 'query',
        description: 'the end date of the event',
        schema: new OA\Schema(type: 'datetime')
    )]
    #[OA\Parameter(
        name: 'location',
        in: 'query',
        description: 'the location of the event',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'Event')]
    #[Route('/{id}/edit', name: '_edit', methods: ['PUT'])]
    public function updateEvent(Request $request, $id)
    {
        $event = $this->EventService->get($id);
        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(EventType::class, $event, array('csrf_protection' => false));
        $form->submit($data, false);

        $event->setStartDate(new DateTime($data['start_date']));
        $event->setEndDate(new DateTime($data['end_date']));

        $event = $this->EventService->persist($event);
        return new JsonResponse($this->EventService->toJson($event));
    }

    #[OA\Response(
        response: 200,
        description: 'Deletes an event',
        content: new OA\JsonContent(
            type: 'string',
        )
    )]
    #[OA\Tag(name: 'Event')]
    #[Route('/{id}/delete', name: '_delete', methods: ['DELETE'])]
    public function deleteEvent($id, Request $request)
    {
        $Event = $this->EventService->get($id);
        try {
            $this->EventService->remove($Event);
            $request->getSession()->getFlashBag()->add('success', 'évènement supprimé avec succès !');
        } catch (\Exception $exception) {
            $request->getSession()->getFlashBag()->add('danger', 'un ou plusieurs objets liés  à cette entité !');
        }

        return new JsonResponse($request);
    }
}
