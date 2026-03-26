<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\Ex03Service;

class Ex03ServiceTest extends TestCase
{
    private Ex03Service $service;

    protected function setUp(): void
    {
        $this->service = new Ex03Service();
    }

    public function testUppercaseWords(): void
    {
        $this->assertEquals('Hello World', $this->service->uppercaseWords('hello world'));

        $this->assertEquals('Sahara Is Hot', $this->service->uppercaseWords('sahara is hot'));

        $this->assertEquals('Test', $this->service->uppercaseWords('test'));

        $this->assertEquals('This Is A Super Test', $this->service->uppercaseWords('this is a super test'));

        $this->assertEquals('Cant Stop Testing', $this->service->uppercaseWords('cant stop testing'));
    }

    public function testCountNumbers(): void
    {
        $this->assertEquals(3, $this->service->countNumbers('abc123'));

        $this->assertEquals(0, $this->service->countNumbers('abcdef'));

        $this->assertEquals(5, $this->service->countNumbers('1a2b3c4d5'));

        $this->assertEquals(11, $this->service->countNumbers('1a2b3c4d5e6f7g8h9i10j'));

        $this->assertEquals(42, $this->service->countNumbers('123456789012345678901234567890123456789012'));
    }
}