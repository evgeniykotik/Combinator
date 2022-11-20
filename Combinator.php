<?php

class Combinator
{
    private string $string;
    private array $array;
    private int $lengthString;
    private int $lengthCombination;

    private $lastCombinationResult = null;

    function __construct($string, $lengthCombination)
    {
        $this->string = $string;
        $this->array = str_split($string);
        $this->lengthString = strlen($string);
        $this->lengthCombination = $lengthCombination;
    }

    private function factorial($n)
    {
        if ($n <= 1) return 1;
        return $n * $this->factorial($n - 1);
    }

    function getCountOfCombinations()
    {
        $this->checkLength();
        return $this->factorial($this->lengthString) /
            $this->factorial(($this->lengthString - $this->lengthCombination));
    }

    private function checkLength()
    {
        if ($this->lengthCombination <= 0 || $this->lengthCombination > $this->lengthString) {
            throw new Exception("Некорректная длина комбинации.
             Длина должна быть > 0 и <= длине строки");
        }
    }

    function combination(): array
    {
        $this->checkLength();
        $this->lastCombinationResult = [];
        $this->cycle([]);
        return $this->lastCombinationResult;
    }

    private function cycle($nums)
    {
        if (count($nums) == $this->lengthCombination) {
            $r = "";
            foreach ($nums as $item) {
                $r .= "{$this->array[$item]}";
            }
            $this->lastCombinationResult[] = $r;
        } else {
            for ($i = 0; $i < $this->lengthString; $i++) {
                if (!in_array($i, $nums)) {
                    $temp = [];
                    foreach ($nums as $num) {
                        $temp[] = $num;
                    }
                    $temp[] = $i;
                    $this->cycle($temp);
                }
            }
        }
    }

}

$a = new Combinator('012', 2);
var_dump($a->combination());
var_dump($a->getCountOfCombinations());
