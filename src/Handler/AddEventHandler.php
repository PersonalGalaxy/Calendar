<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Handler;

use PersonalGalaxy\Calendar\{
    Command\AddEvent,
    Repository\EventRepository,
    Repository\AgendaRepository,
    Entity\Event,
    Exception\AgendaNotFound,
};

final class AddEventHandler
{
    private $events;
    private $agendas;

    public function __construct(
        EventRepository $events,
        AgendaRepository $agendas
    ) {
        $this->events = $events;
        $this->agendas = $agendas;
    }

    public function __invoke(AddEvent $wished): void
    {
        if (!$this->agendas->has($wished->agenda())) {
            throw new AgendaNotFound($wished->agenda());
        }

        $this->events->add(
            Event::add(
                $wished->identity(),
                $wished->agenda(),
                $wished->name(),
                $wished->pointInTime()
            )
        );
    }
}
