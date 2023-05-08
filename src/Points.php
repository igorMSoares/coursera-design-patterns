<?php

use function Sodium\increment;

declare(strict_types=1);

class Points extends Achievement
{
  private int $points;

  public function __construct(string $name)
  {
    $this->name = $name;
    $this->points = 0;
  }

  public function getTotalPoints(): int
  {
    return $this->points;
  }

  public function addPoints(int $increment): void
  {
    $this->points += $increment;
  }
}
