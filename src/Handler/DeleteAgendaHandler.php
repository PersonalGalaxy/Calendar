<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Handler;

use PersonalGalaxy\Calendar\{
    Command\DeleteAgenda,
    Command\CancelEvent,
    Repository\AgendaRepository,
    Repository\EventRepository,
    Entity\Event,
    Specification\Agenda,
};

final class DeleteAgendaHandler
{
    private $agendas;
    private $events;
    private $cancelEvent;

    public function __construct(
        AgendaRepository $agendas,
        EventRepository $events,
        CancelEventHandler $cancelEvent
    ) {
        $this->agendas = $agendas;
        $this->events = $events;
        $this->cancelEvent = $cancelEvent;
    }

    public function __invoke(DeleteAgenda $wished): void
    {
        $agenda = $this->agendas->get($wished->identity());
        $agenda->delete();

        $this
            ->events
            ->matching(new Agenda($wished->identity()))
            ->foreach(function(Event $event): void {
                ($this->cancelEvent)(new CancelEvent($event->identity()));
            });

        $this->agendas->remove($agenda->identity());
    }
}
