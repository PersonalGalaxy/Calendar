<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Command;

use PersonalGalaxy\Calendar\Entity\{
    Agenda\Identity,
    Agenda\Name,
};

final class RenameAgenda
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
