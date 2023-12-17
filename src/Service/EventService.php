<?php

namespace App\Service;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EventService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ValidatorInterface */
    private $validator;

    /**
     * AddressesService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @param int $id
     *
     * @return Event|null
     */
    public function get(int $id): ?Event
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @param array $params
     * @param int|null $limit
     * @param null $offset
     *
     * @return array|null
     */
    public function getEvent(Array $params = array(), int $limit = null, $offset = null): ?array
    {
        return $this->getRepository()->findBy($params, null, $limit, $offset);
    }

    public function getEventByDateAndLocation($date, $location): ?array
    {
        return $this->getRepository()->findByDateAndLocation($date, $location);
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Event::class);
    }

    /**
     * @param Event $Event
     * @return Event
     * @throws \Exception
     */
    public function persist(Event $Event): Event
    {
        try {
            $this->entityManager->persist($Event);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }

        return $Event;
    }

    /**
     * @param Event $Event
     * @return bool
     * @throws \Exception
     */
    public function remove(Event $Event): bool
    {
        $this->entityManager->remove($Event);
        $this->entityManager->flush();

        return true;
    }

    public function save(Event $Event): Event
    {
        $this->entityManager->persist($Event);
        $this->entityManager->flush();

        return $Event;
    }

    public function toJson($event)
    {
        $jsonEvent['id'] = $event->getId();
        $jsonEvent['title'] = $event->getTitle();
        $jsonEvent['description'] = $event->getDescription();
        $jsonEvent['start_date'] = $event->getStartDate()->format('Y-m-d H:i');
        $jsonEvent['end_date'] = $event->getEndDate()->format('Y-m-d H:i');
        $jsonEvent['location'] = $event->getLocation();

        return $jsonEvent;
    }
}
