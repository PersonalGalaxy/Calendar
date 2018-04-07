<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Event;

use PersonalGalaxy\Calendar\{
    Event\EventWasRenamed,
    Entity\Event\Identity,
    Entity\Event\Name,
};
use PHPUnit\Framework\TestCase;

class EventWasRenamedTest extends TestCase
{
    public function testInterface()
    {
        $event = new EventWasRenamed(
            $identity = $this->createMock(Identity::class),
            $name = new Name('foo')
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($name, $event->name());
    }
}
