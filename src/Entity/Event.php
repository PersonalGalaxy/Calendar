<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Entity;

use PersonalGalaxy\Calendar\{
    Entity\Event\Identity,
    Entity\Event\Name,
    Entity\Agenda\Identity as Agenda,
    Event\EventWasAdded,
    Event\EventWasRenamed,
    Event\EventWasMoved,
    Event\EventWasCanceled,
};
use Innmind\TimeContinuum\PointInTimeInterface;
use Innmind\EventBus\{
    ContainsRecordedEventsInterface,
    EventRecorder,
};

final class Event implements ContainsRecordedEventsInterface
{
    use EventRecorder;

    private $identity;
    private $agenda;
    private $name;
    private $pointInTime;

    private function __construct(
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

    public static function add(
        Identity $identity,
        Agenda $agenda,
        Name $name,
        PointInTimeInterface $pointInTime
    ): self {
        $self = new self($identity, $agenda, $name, $pointInTime);
        $self->record(new EventWasAdded($identity, $agenda, $name, $pointInTime));

        return $self;
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

    public function rename(Name $name): self
    {
        if ($name->equals($this->name)) {
            return $this;
        }

        $this->name = $name;
        $this->record(new EventWasRenamed($this->identity, $name));

        return $this;
    }

    public function move(PointInTimeInterface $pointInTime): self
    {
        $this->pointInTime = $pointInTime;
        $this->record(new EventWasMoved($this->identity, $pointInTime));

        return $this;
    }

    /**
     * Last method that can be called, here only to record the event
     */
    public function cancel(): void
    {
        $this->record(new EventWasCanceled($this->identity));
    }
}
