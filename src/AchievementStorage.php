<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

interface AchievementStorage
{
  public static function addAchievement(string $user, Achievement $a): void;

  /**
   * @return Achievement[]
   */
  public static function getAchievements(string $user): array;

  public static function getAchievement(
    string $user,
    string $achievementName
  ): Achievement;
}
