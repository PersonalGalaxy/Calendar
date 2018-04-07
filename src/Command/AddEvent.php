<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Command;

use PersonalGalaxy\Calendar\Entity\{
    Event\Identity,
    Event\Name,
    Agenda\Identity as Agenda,
};
use Innmind\TimeContinuum\PointInTimeInterface;

final class AddEvent
{
    private $identity;
    private $agenda;
    private $name;
    private $pointInTime;

    public function __construct(
        Identity $identity,
        Agenda $agenda,
        Name $name,
        PointInTimeInterface $pointInTime
    ) {
        $this->identity = $identity;
        $this->agenda = $agenda;
        $this->name = $name;
        $this->pointInTime = $pointInTime;
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

    public function pointInTime(): PointInTimeInterface
    {
        return $this->pointInTime;
    }
}
