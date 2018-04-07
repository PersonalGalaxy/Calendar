<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Entity\Agenda;

use PersonalGalaxy\Calendar\Exception\DomainException;
use Innmind\Immutable\Str;

final class Name
{
    private $value;

    public function __construct(string $value)
    {
        if (Str::of($value)->empty()) {
            throw new DomainException;
        }

        $this->value = $value;
    }

    public function equals(self $name): bool
    {
        return (string) $this === (string) $name;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
