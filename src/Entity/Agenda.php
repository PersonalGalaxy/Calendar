<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Entity;

use PersonalGalaxy\Calendar\{
    Entity\Agenda\Identity,
    Entity\Agenda\User,
    Entity\Agenda\Name,
    Event\AgendaWasAdded,
    Event\AgendaWasRenamed,
    Event\AgendaWasDeleted,
};
use Innmind\EventBus\{
    ContainsRecordedEventsInterface,
    EventRecorder,
};

final class Agenda implements ContainsRecordedEventsInterface
{
    use EventRecorder;

    private $identity;
    private $user;
    private $name;

    private function __construct(Identity $identity, User $user, Name $name)
    {
        $this->identity = $identity;
        $this->user = $user;
        $this->name = $name;
    }

    public static function add(Identity $identity, User $user, Name $name): self
    {
        $self = new self($identity, $user, $name);
        $self->record(new AgendaWasAdded($identity, $user, $name));

        return $self;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function rename(Name $name): self
    {
        if ($name->equals($this->name)) {
            return $this;
        }

        $this->name = $name;
        $this->record(new AgendaWasRenamed($this->identity, $name));

        return $this;
    }

    /**
     * Last method that can be called, here only to record the event
     */
    public function delete(): void
    {
        $this->record(new AgendaWasDeleted($this->identity));
    }
}
