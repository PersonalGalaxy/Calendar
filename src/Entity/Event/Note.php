<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Entity\Event;

final class Note
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
