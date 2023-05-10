<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

interface AchievementObserver
{
  public function achievementUpdate(string $user, Achievement $a): void;
}
