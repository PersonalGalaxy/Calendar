<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Command;

use PersonalGalaxy\Calendar\{
    Command\RenameEvent,
    Entity\Event\Identity,
    Entity\Event\Name,
};
use PHPUnit\Framework\TestCase;

class RenameEventTest extends TestCase
{
    public function testInterface()
    {
        $event = new RenameEvent(
            $identity = $this->createMock(Identity::class),
            $name = new Name('foo')
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($name, $event->name());
    }
}
