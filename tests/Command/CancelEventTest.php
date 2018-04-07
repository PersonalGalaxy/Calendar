<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Command;

use PersonalGalaxy\Calendar\{
    Command\CancelEvent,
    Entity\Event\Identity,
};
use PHPUnit\Framework\TestCase;

class CancelEventTest extends TestCase
{
    public function testInterface()
    {
        $event = new CancelEvent(
            $identity = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $event->identity());
    }
}
