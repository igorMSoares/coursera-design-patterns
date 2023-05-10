<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

interface AchievementStorage
{
  public function attachAchievementObserver(AchievementObserver $o): void;

  public function addAchievement(string $user, Achievement $a): void;

  /**
   * @return Achievement[]
   */
  public function getAchievements(string $user): array;

  public function getAchievement(
    string $user,
    string $achievementName
  ): Achievement;
}
