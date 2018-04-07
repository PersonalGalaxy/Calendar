<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Event;

use PersonalGalaxy\Calendar\{
    Event\EventWasCanceled,
    Entity\Event\Identity,
};
use PHPUnit\Framework\TestCase;

class EventWasCanceledTest extends TestCase
{
    public function testInterface()
    {
        $event = new EventWasCanceled(
            $identity = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $event->identity());
    }
}
