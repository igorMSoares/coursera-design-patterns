<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

use PHPUnit\Framework\TestCase;

final class MemoryAchievementStorageTest extends TestCase
{
  public function testGetAchievementReturnsNullAchievementIfAchievementNotFound(): void
  {
    $user = 'user1';

    AchievementStorageFactory::setAchievementStorage(new MemoryAchievementStorage());
    $achievementStorage = AchievementStorageFactory::getAchievementStorage();

    $achievement = $achievementStorage->getAchievement($user, 'NON EXISTENT');
    $this->assertTrue($achievement instanceof NullAchievement);

    $achievementStorage->addAchievement($user, new Points('CREATION', 5));
    $achievement = $achievementStorage->getAchievement($user, 'CREATION');
    $this->assertTrue($achievement instanceof Points);
  }

  public function testObserversBeingNotified(): void
  {
    $user = 'user1';

    AchievementStorageFactory::setAchievementStorage(new MemoryAchievementStorage());
    $achievementStorage = AchievementStorageFactory::getAchievementStorage();

    $achievementStorage->attachAchievementObserver(
      new CreationAchievementObserver($achievementStorage)
    );
    $achievementStorage->attachAchievementObserver(
      new ParticipationAchievementObserver($achievementStorage)
    );

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
