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
    if ($a instanceof NullAchievement) return;

    if (!property_exists($this->achievementsList, $user))
      !$this->achievementsList->$user = [];

    $this->achievementsList->$user[] = $a;
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
      if ($achievement->getName() === $achievementName) return $achievement;
    }

    return new NullAchievement;
  }
}
