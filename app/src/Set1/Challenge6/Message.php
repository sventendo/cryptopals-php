<?php

namespace Sventendo\Cryptopals\Set1\Challenge6;

class Message
{
    private $text = '';
    private $hitRate = 0;
    private $modifierValue = 0;

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function addText(string $text): void
    {
        $this->text .= $text;
    }

    public function getHitRate(): float
    {
        return $this->hitRate;
    }

    public function setHitRate(float $hitRate): void
    {
        $this->hitRate = $hitRate;
    }

    public function setModifierValue(int $modifierValue)
    {
        $this->modifierValue = $modifierValue;
    }

    public function getModifierValue(): int
    {
        return $this->modifierValue;
    }
}
