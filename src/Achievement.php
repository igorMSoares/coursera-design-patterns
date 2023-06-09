<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

abstract class Achievement
{
  protected string $name;

  public function getName(): string
  {
    return $this->name;
  }
}
