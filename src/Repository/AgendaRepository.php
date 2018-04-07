<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Repository;

use PersonalGalaxy\Calendar\Entity\{
    Agenda,
    Agenda\Identity,
};
use Innmind\Immutable\SetInterface;
use Innmind\Specification\SpecificationInterface;

interface AgendaRepository
{
    /**
     * @throws AgendaNotFound
     */
    public function get(Identity $identity): Agenda;
    public function add(Agenda $agenda): self;
    public function remove(Identity $identity): self;
    public function has(Identity $identity): bool;
    public function count(): int;
    /**
     * @return SetInterface<Agenda>
     */
    public function all(): SetInterface;
    /**
     * @return SetInterface<Agenda>
     */
    public function matching(SpecificationInterface $specification): SetInterface;
}
