<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Entity\Event;

use PersonalGalaxy\Calendar\Entity\Event\Note;
use PHPUnit\Framework\TestCase;
use Eris\{
    Generator,
    TestTrait,
};

class NoteTest extends TestCase
{
    use TestTrait;

    public function testInterface()
    {
        $this
            ->forAll(Generator\string())
            ->then(function(string $string): void {
                $this->assertSame($string, (string) new Note($string));
            });
    }
}
