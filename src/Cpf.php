<?php

namespace App;

use UnexpectedValueException;

class Cpf
{
    const FACTOR_DIGIT_1 = 10;
    const FACTOR_DIGIT_2 = 11;
    const MAX_DIGIT_1 = 9;
    const MAX_DIGIT_2 = 10;

    public function __construct(string $cpf)
    {
        $this->validate($cpf);
    }

    public function validate(string $cpf): void
    {
        $cpf = $this->extractDigits($cpf);

        if ($this->isInvalidLength($cpf)) {
            throw new UnexpectedValueException("Invalid CPF!");
        }
        if ($this->allDigitsAreEqual($cpf)) {
            throw new UnexpectedValueException("Invalid CPF!");
        }

        $digit1 = $this->calculateDigit($cpf, self::FACTOR_DIGIT_1, self::MAX_DIGIT_1);
        $digit2 = $this->calculateDigit($cpf, self::FACTOR_DIGIT_2, self::MAX_DIGIT_2);
        $calculatedCheckDigit = $digit1 . $digit2;

        if ($this->getCheckerDigit($cpf) != $calculatedCheckDigit) {
            throw new UnexpectedValueException("Invalid CPF!");
        }
    }

    private function extractDigits(string $cpf): string
    {
        return preg_replace("(\D+)", "", $cpf);
    }


    private function isInvalidLength(string $cpf): bool
    {
        return strlen($cpf) !== 11;
    }

    private function allDigitsAreEqual(string $cpf): bool
    {
        $firstDigit = substr($cpf, 0, 1);
        $equals = 0;
        for ($letter = 0; $letter < strlen($cpf); $letter++) {
            if ($firstDigit === substr($cpf, $letter, 1)) {
                $equals++;
            }
        }

        return $equals === strlen($cpf);
    }

    private function calculateDigit(string $cpf, int $factor, int $max): int
    {
        $total = 0;
        for ($position = 0; $position < $max; $position++) {
            $digit = substr($cpf, $position, 1);
            $total += $digit * $factor--;
        }

        $rest = $total % 11;
        return ($rest < 2) ? 0 : (11 - $rest);
    }

    private function getCheckerDigit(string $cpf): int
    {
        return (int) (substr($cpf, 9, 2));
    }
}
