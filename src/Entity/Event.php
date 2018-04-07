<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Entity;

use PersonalGalaxy\Calendar\{
    Entity\Event\Identity,
    Entity\Event\Name,
    Entity\Event\Slot,
    Entity\Event\Note,
    Entity\Agenda\Identity as Agenda,
    Event\EventWasAdded,
    Event\EventWasRenamed,
    Event\EventWasMoved,
    Event\EventWasCanceled,
    Event\Event\NoteWasAdded,
};
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
    private $slot;
    private $note;

    private function __construct(
        Identity $identity,
        Agenda $agenda,
        Name $name,
        Slot $slot
    ) {
        $this->identity = $identity;
        $this->agenda = $agenda;
        $this->name = $name;
        $this->slot = $slot;
        $this->note = new Note('');
    }

    public static function add(
        Identity $identity,
        Agenda $agenda,
        Name $name,
        Slot $slot
    ): self {
        $self = new self($identity, $agenda, $name, $slot);
        $self->record(new EventWasAdded($identity, $agenda, $name, $slot));

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

    public function slot(): Slot
    {
        return $this->slot;
    }

    public function note(): Note
    {
        return $this->note;
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

    public function move(Slot $slot): self
    {
        $this->slot = $slot;
        $this->record(new EventWasMoved($this->identity, $slot));

        return $this;
    }

    public function addNote(Note $note): self
    {
        $this->note = $note;
        $this->record(new NoteWasAdded($this->identity, $note));

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
