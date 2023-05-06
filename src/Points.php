<?php

declare(strict_types=1);

class Points extends Achievement
{
  private int $points;

  public function __construct(int $userId, string $name)
  {
    $this->userId = $userId;
    $this->name = $name;
    $this->points = 0;
  }

  public function getTotalPoints(): int
  {
    return $this->points;
  }
}
