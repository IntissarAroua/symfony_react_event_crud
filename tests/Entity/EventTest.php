<?php

namespace App\tests\Entity;

use App\Entity\Event;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    public function testUri()
    {
        $event = new Event();

        $title = "Event";
        $description = "This is event.";
        $start_date = new \DateTime();
        $end_date = new \DateTime();
        $location = "Location";
        
        $event->setTitle($title);
        $this->assertEquals($title, $event->getTitle());

        $event->setDescription($description);
        $this->assertEquals($description, $event->getDescription());

        $event->setStartDate($start_date);
        $this->assertEquals($start_date, $event->getStartDate());

        $event->setEndDate($end_date);
        $this->assertEquals($end_date, $event->getEndDate());

        $event->setLocation($location);
        $this->assertEquals($location, $event->getLocation());
    }
}