<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Command;

use PersonalGalaxy\Calendar\Entity\Agenda\{
    Identity,
    User,
    Name,
};

final class AddAgenda
{
    private $identity;
    private $user;
    private $name;

    public function __construct(Identity $identity, User $user, Name $name)
    {
        $this->identity = $identity;
        $this->user = $user;
        $this->name = $name;
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
}
