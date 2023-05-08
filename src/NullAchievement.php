<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

class NullAchievement extends Achievement
{
  public function __construct()
  {
    $this->name = '';
  }
}
