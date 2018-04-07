<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Command\Event;

use PersonalGalaxy\Calendar\Entity\Event\{
    Identity,
    Note,
};

final class AddNote
{
    private $identity;
    private $note;

    public function __construct(Identity $identity, Note $note)
    {
        $this->identity = $identity;
        $this->note = $note;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }

    public function note(): Note
    {
        return $this->note;
    }
}
