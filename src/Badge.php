<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

class Badge extends Achievement
{
  public function __construct(string $name)
  {
    $this->name = $name;
  }
}
