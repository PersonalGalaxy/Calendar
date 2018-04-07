<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Event;

use PersonalGalaxy\Calendar\Entity\{
    Event\Identity,
    Event\Name,
    Event\Slot,
    Agenda\Identity as Agenda,
};

final class EventWasAdded
{
    private $identity;
    private $agenda;
    private $name;
    private $slot;

    public function __construct(
        Identity $identity,
        Agenda $agenda,
        Name $name,
        Slot $slot
    ) {
        $this->identity = $identity;
        $this->agenda = $agenda;
        $this->name = $name;
        $this->slot = $slot;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }

    public function agenda(): Agenda
    {
        return $this->agenda;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function slot(): Slot
    {
        return $this->slot;
    }
}
