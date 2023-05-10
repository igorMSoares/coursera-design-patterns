<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

use PHPUnit\Framework\TestCase;

final class ParticipationAchievementObserverTest extends TestCase
{
  public function testAddingCommunityBadgeOn100ParticipationPoints(): void
  {
    $user = 'user1';

    AchievementStorageFactory::setAchievementStorage(new MemoryAchievementStorage());
    $achievementStorage = AchievementStorageFactory::getAchievementStorage();

    $participationObserver = new ParticipationAchievementObserver($achievementStorage);

    $participationAchievement = new Points('PARTICIPATION', 100);
    $achievementStorage->addAchievement($user, $participationAchievement);

    $participationObserver->achievementUpdate($user, $participationAchievement);

    $communityBadge = $achievementStorage->getAchievement(
      $user,
      'PART OF THE COMMUNITY'
    );

    $this->assertTrue($communityBadge instanceof Badge);
  }
}
