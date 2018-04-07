<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Handler;

use PersonalGalaxy\Calendar\{
    Handler\AddAgendaHandler,
    Command\AddAgenda,
    Repository\AgendaRepository,
    Entity\Agenda,
    Entity\Agenda\Identity,
    Entity\Agenda\User,
    Entity\Agenda\Name,
    Event\AgendaWasAdded,
};
use PHPUnit\Framework\TestCase;

class AddAgendaHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new AddAgendaHandler(
            $repository = $this->createMock(AgendaRepository::class)
        );
        $command = new AddAgenda(
            $this->createMock(Identity::class),
            $this->createMock(User::class),
            new Name('foo')
        );
        $repository
            ->expects($this->once())
            ->method('add')
            ->with($this->callback(static function(Agenda $agenda) use ($command): bool {
                return $agenda->identity() === $command->identity() &&
                    $agenda->user() === $command->user() &&
                    $agenda->name() === $command->name() &&
                    $agenda->recordedEvents()->first() instanceof AgendaWasAdded;
            }));

        $this->assertNull($handle($command));
    }
}
