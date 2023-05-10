<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

use PHPUnit\Framework\TestCase;

final class MemoryAchievementStorageTest extends TestCase
{
  public function testObserversBeingNotified(): void
  {
    $user = 'user1';

    AchievementStorageFactory::setAchievementStorage(new MemoryAchievementStorage());
    $achievementStorage = AchievementStorageFactory::getAchievementStorage();

    if ($achievementStorage instanceof MemoryAchievementStorage) {
      $achievementStorage->attachAchievementObserver(
        new CreationAchievementObserver($achievementStorage)
      );
      $achievementStorage->attachAchievementObserver(
        new ParticipationAchievementObserver($achievementStorage)
      );
    }

    $participationAchievement = new Points('PARTICIPATION', 100);
    $achievementStorage->addAchievement($user, $participationAchievement);

    $creationAchievement = new Points('CREATION', 100);
    $achievementStorage->addAchievement($user, $creationAchievement);

    $communityBadge = $achievementStorage->getAchievement(
      $user,
      'PART OF THE COMMUNITY'
    );

    $inventorBadge = $achievementStorage->getAchievement(
      $user,
      'INVENTOR'
    );

    $this->assertTrue($communityBadge instanceof Badge);
    $this->assertTrue($inventorBadge instanceof Badge);
  }
}
