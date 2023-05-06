<?php

declare(strict_types=1);

class NullAchievement extends Achievement
{
  public function __construct()
  {
    $this->userId = -1;
    $this->name = '';
  }
}
