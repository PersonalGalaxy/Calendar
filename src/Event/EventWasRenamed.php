<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Event;

use PersonalGalaxy\Calendar\Entity\{
    Event\Identity,
    Event\Name,
};

final class EventWasRenamed
{
    private $identity;
    private $name;

    public function __construct(Identity $identity, Name $name)
    {
        $this->identity = $identity;
        $this->name = $name;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }

    public function name(): Name
    {
        return $this->name;
    }
}
