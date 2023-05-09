<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

use stdClass;

class MemoryAchievementStorage implements AchievementStorage
{
  private $achievementsList;

  public function __construct()
  {
    $this->achievementsList = new stdClass();
  }

  public function addAchievement(string $user, Achievement $a): void
  {
    if (!$this->achievementsList->$user) !$this->achievementsList->$user = [];

    $userAchievement = $this->getAchievement($user, $a->getName());

    // add achievement only if it doesn't already exists
    if (!($userAchievement instanceof NullAchievement)) {
      // push $a into achievementsList->$user
      $this->achievementsList->$user[] = $a;
    }
  }

  public function getAchievements(string $user): array
  {
    return property_exists($this->achievementsList, $user)
      ? $this->achievementsList->$user
      : [];
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
