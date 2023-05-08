<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

class MemoryAchievementStorage implements AchievementStorage
{
  private object $achievementsList;

  public static function addAchievement(string $user, Achievement $a): void
  {
    if (!self::$achievementsList[$user]) !self::$achievementsList[$user] = [];

    $userAchievement = self::getAchievement($user, $a->getName());

    // add achievement only if it doesn't already exists
    if ($userAchievement instanceof NullAchievement) {
      // push $a into achievementsList[$user]
      self::$achievementsList[$user][] = $a;
    }
  }

  public static function getAchievements(string $user): array
  {
    return self::$achievementsList[$user];
  }

  public static function getAchievement(string $user, string $achievementName): Achievement
  {
    $userAchievements = self::getAchievements($user);

    foreach ($userAchievements as $achievement) {
      if ($achievement['name'] === $achievementName) return $achievement;
    }

    return new NullAchievement;
  }
}
