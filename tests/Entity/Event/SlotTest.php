<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Entity\Event;

use PersonalGalaxy\Calendar\{
    Entity\Event\Slot,
    Exception\LogicException,
    Exception\EmptySlot,
};
use Innmind\TimeContinuum\{
    PointInTimeInterface,
    PointInTime\Earth\PointInTime,
};
use PHPUnit\Framework\TestCase;

class SlotTest extends TestCase
{
    public function testThrowWhenStartAheadOfEnd()
    {
        $this->expectException(LogicException::class);
        $start = $this->createMock(PointInTimeInterface::class);
        $end = $this->createMock(PointInTimeInterface::class);
        $start
            ->expects($this->once())
            ->method('aheadOf')
            ->with($end)
            ->willReturn(true);

        new Slot($start, $end);
    }

    public function testThrowWhenStartEqualsEnd()
    {
        $this->expectException(EmptySlot::class);
        $start = $this->createMock(PointInTimeInterface::class);
        $end = $this->createMock(PointInTimeInterface::class);
        $start
            ->expects($this->once())
            ->method('equals')
            ->with($end)
            ->willReturn(true);

        new Slot($start, $end);
    }

    public function testInterface()
    {
        $start = $this->createMock(PointInTimeInterface::class);
        $end = $this->createMock(PointInTimeInterface::class);

        $slot = new Slot($start, $end);

        $this->assertSame($start, $slot->start());
        $this->assertSame($end, $slot->end());
    }

    /**
     * @dataProvider cases
     */
    public function testOverlaps($aStart, $aEnd, $bStart, $bEnd, $expected)
    {
        $a = new Slot(
            new PointInTime($aStart),
            new PointInTime($aEnd)
        );
        $b = new Slot(
            new PointInTime($bStart),
            new PointInTime($bEnd)
        );

        $this->assertSame($expected, $a->overlaps($b));
    }

    public function cases(): array
    {
        return [
            /**
             * a: |---|
             * b: |---|
             */
            ['2018-01-01', '2018-01-04', '2018-01-01', '2018-01-04', true],
            /**
             * a: |---|
             * b:  |---|
             */
            ['2018-01-01', '2018-01-04', '2018-01-02', '2018-01-05', true],
            /**
             * a:  |---|
             * b: |---|
             */
            ['2018-01-02', '2018-01-05', '2018-01-01', '2018-01-04', true],
            /**
             * a:  |-|
             * b: |---|
             */
            ['2018-01-02', '2018-01-03', '2018-01-01', '2018-01-04', true],
            /**
             * a: |---|
             * b:  |-|
             */
            ['2018-01-01', '2018-01-04', '2018-01-02', '2018-01-03', true],
            /**
             * a: |---|
             * b:     |---|
             */
            ['2018-01-01', '2018-01-04', '2018-01-04', '2018-01-07', false],
            /**
             * a: |---|
             * b:      |---|
             */
            ['2018-01-01', '2018-01-04', '2018-01-05', '2018-01-08', false],
            /**
             * a:     |---|
             * b: |---|
             */
            ['2018-01-04', '2018-01-07', '2018-01-01', '2018-01-04', false],
            /**
             * a:      |---|
             * b: |---|
             */
            ['2018-01-05', '2018-01-08', '2018-01-01', '2018-01-04', false],
        ];
    }
}
