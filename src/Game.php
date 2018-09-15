<?php

class Game {
    private $objects;
    private $totalRoundsCount;
    private $currentResult;

    const FIRST_PLAYER = 1;
    const SECOND_PLAYER = 2;
    const TIE = -1;

    public function __construct() {
        $this->objects = array(
            'paper',
            'scissor',
            'stone',
        );

        //Init the count of rounds explicitly
        $this->playRounds(3);

        $this->currentResult = array(
            1 => 0,
            2 => 0
        );

        require_once 'CLI.php';
    }

    public function playRounds($rounds = 3) {
        $this->checkIsInt($rounds);
        $this->checkIsPositive($rounds);
        $this->checkIsOdd($rounds);

        $this->setRounds($rounds);
    }

    public function setRounds($rounds) {
        $this->totalRoundsCount = $rounds;
    }

    private function getRounds() {
        return $this->totalRoundsCount;
    }

    private function checkIsPositive($number) {
        if($number < 0) {
            throw new Exception("Should be positive");
        }
    }

    private function checkIsInt($number) {
        if(!is_int($number)) {
            throw new Exception("Number of rounds should be integer");
        }
    }

    private function checkIsOdd($number) {
        if($number % 2 == 0) {
            throw new Exception("Rounds should be odd number");
        }
    }

    private function getObjectPerId($id) {
        return $this->objects[$id];
    }

    /*
    Please note that the returned integer is not truly random,
    but it's good enough for the current case
    */
    private function getRandomInteger() {
        $totalObjectCount = count($this->getObjects());

        return rand(0, $totalObjectCount - 1);
    }

    private function judgeWinner($firstPlayerChoice, $secondPlayerChoice) {
        $maxPossibleChoice = count($this->getObjects()) - 1;

        //This is the so called edge cases
        if($firstPlayerChoice == 0 && $secondPlayerChoice == $maxPossibleChoice) return self::FIRST_PLAYER;
        if($firstPlayerChoice == $maxPossibleChoice && $secondPlayerChoice == 0) return self::SECOND_PLAYER;

        if($firstPlayerChoice > $secondPlayerChoice) {
            return self::FIRST_PLAYER;
        }
        else if($firstPlayerChoice < $secondPlayerChoice) {
            return self::SECOND_PLAYER;
        }
        else {
            return self::TIE;
        }
    }

    public function insertOneObject($objectName, $objectPosition) {
        $this->checkIsInt($objectPosition);
        $this->checkIsPositive($objectPosition);

        array_splice($this->getObjects(), $objectPosition, 0, $objectName);
        $this->objects = array_values($this->objects);
    }

    private function getObjects() {
        return $this->objects;
    }

    public function insertManyObjects($objectsArray) {
        //To Do
    }

    private function updateResult($winnerId) {
        $this->currentResult[$winnerId]++;
    }

    public function play() {
        $currentRound = 1;
        $totalRounds = $this->getRounds();

        while($currentRound <= $totalRounds) {
            CLI::printLine("Current round is: $currentRound", 2);

            $firstPlayerChoice = $this->getRandomInteger();
            $secondPlayerChoice = $this->getRandomInteger();

            CLI::printLine("==========");
            CLI::printLine("First Player Choice: " .  $this->getObjectPerId($firstPlayerChoice));
            CLI::printLine("Second Player Choice: " .  $this->getObjectPerId($secondPlayerChoice));

            $resultOfRound = $this->judgeWinner($firstPlayerChoice, $secondPlayerChoice);

            if(self::TIE == $resultOfRound) {
                CLI::printLine("Uh Oh, it's a tie, let's try again");
                continue;
            }
            CLI::printLine("Player $resultOfRound has won in the current round");

            $this->updateResult($resultOfRound);
            $currentRound++;
        }

        CLI::printLine("OK, the game has ended and there are a winner.", 1);
    }

    private function getWinner() {
        asort($this->currentResult);
        end($this->currentResult);
        $winner = key($this->currentResult);
        $totalWinGames = array_pop($this->currentResult);
        return array($winner, $totalWinGames);
    }

    public function winner() {
        list($winner, $totalWinGames) = $this->getWinner();

        CLI::printLine("Player No. $winner has won the game with total $totalWinGames wins", 1);
    }
}

$game = new Game();
$game->insertOneObject("lizard", 2);
$game->playRounds(5);
$game->play();
$game->winner();
