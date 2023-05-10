<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

use PHPUnit\Framework\TestCase;

final class CreationAchievementObserverTest extends TestCase
{
  public function testAddingInventorBadgeOn100CreationPoints(): void
  {
    $user = 'user1';

    AchievementStorageFactory::setAchievementStorage(new MemoryAchievementStorage());
    $achievementStorage = AchievementStorageFactory::getAchievementStorage();

    $creationObserver = new CreationAchievementObserver($achievementStorage);

    $creationAchievement = new Points('CREATION', 100);
    $achievementStorage->addAchievement($user, $creationAchievement);

    $creationObserver->achievementUpdate($user, $creationAchievement);

    $inventorBadge = $achievementStorage->getAchievement($user, 'INVENTOR');

    $this->assertTrue($inventorBadge instanceof Badge);
  }

  public function testDontAddInventorBadgeOnLessThan100CreationPoints(): void
  {
    $user = 'user1';

    AchievementStorageFactory::setAchievementStorage(new MemoryAchievementStorage());
    $achievementStorage = AchievementStorageFactory::getAchievementStorage();

    $creationObserver = new CreationAchievementObserver($achievementStorage);

    $creationAchievement = new Points('CREATION', 99);
    $achievementStorage->addAchievement($user, $creationAchievement);

    $creationObserver->achievementUpdate($user, $creationAchievement);

    $inventorBadge = $achievementStorage->getAchievement($user, 'INVENTOR');

    $this->assertTrue($inventorBadge instanceof NullAchievement);
  }
}
