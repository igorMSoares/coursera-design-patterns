<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

use stdClass;

class MemoryAchievementStorage implements AchievementStorage
{
  private $achievementsList;
  /**
   * @var AchievementObserver[]
   */
  private $achievementObserversList = [];

  public function __construct()
  {
    $this->achievementsList = new stdClass();
  }

  public function attachAchievementObserver(AchievementObserver $o): void
  {
    $this->achievementObserversList[] = $o;
  }

  public function addAchievement(string $user, Achievement $a): void
  {
    if ($a instanceof NullAchievement) return;

    if (!property_exists($this->achievementsList, $user))
      !$this->achievementsList->$user = [];

    $this->achievementsList->$user[] = $a;

    foreach ($this->achievementObserversList as $achievementObserver) {
      $achievementObserver->achievementUpdate($user, $a);
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
      if ($achievement->getName() === $achievementName) return $achievement;
    }

    return new NullAchievement;
  }
}
