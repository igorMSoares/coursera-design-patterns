<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

class MemoryAchievementStorage implements AchievementStorage
{
  private object $achievementsList;

  public function addAchievement(string $user, Achievement $a): void
  {
    if (!$this->achievementsList[$user]) !$this->achievementsList[$user] = [];

    // push $a into achievementsList[$user]
    $this->achievementsList[$user][] = $a;
  }

  public function getAchievements(string $user): array
  {
    return $this->achievementsList[$user];
  }

  public function getAchievement(string $user, string $achievementName): Achievement
  {
    $userAchievements = $this->getAchievements($user);

    foreach ($userAchievements as $achievement) {
      if ($achievement['name'] === $achievementName) return $achievement;
    }

    return new NullAchievement;
  }
}
