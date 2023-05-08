<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

class Points extends Achievement
{
  private int $points;

  public function __construct(string $name, int $points = 0)
  {
    $this->name = $name;
    $this->points = $points;
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
