<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    const Events = [
        [
            'name' => 'Event 1',
            'date' => '2024-11-30 10:24:00',
            'location' => 'Lille',
            'latitude' => '50.633333',
            'longitude' => '3.066667'
        ],
        [
            'name' => 'Event 2',
            'date' => '2025-03-06 10:26:44',
            'location' => 'Lomme',
            'latitude' => '50.6457022',
            'longitude' => '2.9870927'
        ],
        [
            'name' => 'Event 3',
            'date' => '2025-03-20 14:08:19',
            'location' => 'Lambersart',
            'latitude' => '50.650002',
            'longitude' => '3.03333'
        ]
    ];

    public function load(ObjectManager $manager): void
    {

        foreach (self::Events as $event) {
            $eventToPersist = new Event();
            $eventToPersist->setName($event['name']);
            $eventToPersist->setDate(new \DateTime($event['date']));
            $eventToPersist->setLocation($event['location']);
            $eventToPersist->setLatitude($event['latitude']);
            $eventToPersist->setLongitude($event['longitude']);
            $manager->persist($eventToPersist);
        }

        $manager->flush();
    }
}
