<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

class CreationAchievementObserver implements AchievementObserver
{
  private AchievementStorage $achievementStorage;

  public function __construct(AchievementStorage $achievementStorage)
  {
    $this->achievementStorage = $achievementStorage;
  }

  public function achievementUpdate(string $user, Achievement $a): void
  {
    if (!($a instanceof Points) || $a->getName() != 'CREATION') return;

    $totalCreationPoints = $a->getTotalPoints();
    if ($totalCreationPoints >= 100) {
      $inventorBadge = $this->achievementStorage->getAchievement($user, 'INVENTOR');

      // 'INVENTOR' Badge already exists
      if ($inventorBadge instanceof Badge) return;

      $this->achievementStorage->addAchievement($user, new Badge('INVENTOR'));
    }
  }
}
