<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

use PHPUnit\Framework\TestCase;

final class ForumServiceGamificationProxyTest extends TestCase
{
  public function testForumServiceAddingBadgeAndPointsOnAddTopic(): void
  {
    $user = 'user1';

    AchievementStorageFactory::setAchievementStorage(new MemoryAchievementStorage());
    $forumService = new ForumServiceGamificationProxy(new ForumServiceGamification());
    $forumService->addTopic($user, 'topicName');

    $creationPoints = 5;
    $badgeName = 'I CAN TALK';

    $achievementStorage = AchievementStorageFactory::getAchievementStorage();
    $pointsAchievement =  $achievementStorage->getAchievement($user, 'CREATION');
    $badgeAchievement = $achievementStorage->getAchievement($user, $badgeName);

    if ($pointsAchievement instanceof Points) {
      $points = $pointsAchievement->getTotalPoints();
    }
    if ($badgeAchievement instanceof Badge) {
      $badge = $badgeAchievement->getName();
    }
    $this->assertSame($creationPoints, $points);
    $this->assertSame($badgeName, $badge);
  }

  public function testForumServiceAddingBadgeAndPointsOnAddComment(): void
  {
    $user = 'user1';

    AchievementStorageFactory::setAchievementStorage(new MemoryAchievementStorage());
    $forumService = new ForumServiceGamificationProxy(new ForumServiceGamification());
    $forumService->addComment($user, 'topicName', 'comment');

    $participationPoints = 3;
    $badgeName = 'LET ME ADD';

    $achievementStorage = AchievementStorageFactory::getAchievementStorage();
    $pointsAchievement =  $achievementStorage->getAchievement($user, 'PARTICIPATION');
    $badgeAchievement = $achievementStorage->getAchievement($user, $badgeName);

    if ($pointsAchievement instanceof Points) {
      $points = $pointsAchievement->getTotalPoints();
    }
    if ($badgeAchievement instanceof Badge) {
      $badge = $badgeAchievement->getName();
    }
    $this->assertSame($participationPoints, $points);
    $this->assertSame($badgeName, $badge);
  }
  public function testForumServiceAddingBadgeAndPointsOnLikeTopic(): void
  {
    $user = 'user1';

    AchievementStorageFactory::setAchievementStorage(new MemoryAchievementStorage());
    $forumService = new ForumServiceGamificationProxy(new ForumServiceGamification());
    $forumService->likeTopic($user, 'topicName', 'user2');

    $creationPoints = 1;

    $achievementStorage = AchievementStorageFactory::getAchievementStorage();
    $pointsAchievement =  $achievementStorage->getAchievement($user, 'CREATION');

    if ($pointsAchievement instanceof Points) {
      $points = $pointsAchievement->getTotalPoints();
    }
    $this->assertSame($creationPoints, $points);
  }
}
