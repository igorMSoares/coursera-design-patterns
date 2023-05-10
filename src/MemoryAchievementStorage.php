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

    $storedAchievement = $this->getAchievement($user, $a->getName());

    // If there is no achievement with this name already, then add it
    if ($storedAchievement instanceof NullAchievement) {
      $this->achievementsList->$user[] = $a;
    } else if ($storedAchievement instanceof Points && $a instanceof Points) {
      // There's already a Points achievement with this name, so increment it
      $storedAchievement->addPoints($a->getTotalPoints());
    }

    $updatedAchievement = $this->getAchievement($user, $a->getName());
    foreach ($this->achievementObserversList as $achievementObserver) {
      $achievementObserver->achievementUpdate($user, $updatedAchievement);
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
