<?php

use PHPUnit\Framework\TestCase;

class GameTest extends TestCase {

    private $gameInstance;

    public function __construct() {
        parent::__construct();

        $this->gameInstance = new Game();
    }

    public function testPlayRoundsThrowWhenBuiltFromNonIntegerValue() {
        $this->expectException(Exception::class);
        $this->gameInstance->playRounds('a');
    }

    public function testPlayRoundsThrowWhenBuiltFromNonPositiveIntegerValue() {
        $this->expectException(Exception::class);
        $this->gameInstance->playRounds(-1);
    }

    public function testPlayRoundsThrowWhenBuiltFromNonOddIntegerValue() {
        $this->expectException(Exception::class);
        $this->gameInstance->playRounds(4);
    }

    public function testPlayRoundsCanBeCreatedFromValidInput() {
        $this->assertTrue($this->gameInstance->playRounds(5));
    }

    public function testInsertOneObjectCannotBeCreatedFromNonIntegerValue() {
        $this->expectException(Exception::class);
        $this->gameInstance->insertOneObject('a', 'a');
    }

    public function testInsertOneObjectCannotBeCreatedFromNonPositiveIntegerValue() {
        $this->expectException(Exception::class);
        $this->gameInstance->insertOneObject('a', -1);
    }

    public function testInsertOneObjectCanBeCreatedWithValidInput() {
        $this->assertTrue($this->gameInstance->insertOneObject('testAssert', 3));
    }
}
