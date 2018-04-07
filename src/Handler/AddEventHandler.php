<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Handler;

use PersonalGalaxy\Calendar\{
    Command\AddEvent,
    Repository\EventRepository,
    Repository\AgendaRepository,
    Entity\Event,
    Exception\EventCannotBeDeclaredInThePast,
    Exception\AgendaNotFound,
};
use Innmind\TimeContinuum\TimeContinuumInterface;

final class AddEventHandler
{
    private $events;
    private $agendas;
    private $clock;

    public function __construct(
        EventRepository $events,
        AgendaRepository $agendas,
        TimeContinuumInterface $clock
    ) {
        $this->events = $events;
        $this->agendas = $agendas;
        $this->clock = $clock;
    }

    public function __invoke(AddEvent $wished): void
    {
        if ($this->clock->now()->aheadOf($wished->pointInTime())) {
            throw new EventCannotBeDeclaredInThePast($wished->pointInTime());
        }

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
