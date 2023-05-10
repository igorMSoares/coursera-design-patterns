<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

use PHPUnit\Framework\MockObject\MockObject;
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

  public function testForumServiceAddingBadgeAndPointsOnAddTopicTwice(): void
  {
    $user = 'user1';

    AchievementStorageFactory::setAchievementStorage(new MemoryAchievementStorage());
    $forumService = new ForumServiceGamificationProxy(new ForumServiceGamification());
    $forumService->addTopic($user, 'firstTopic');
    $forumService->addTopic($user, 'secondTopic');

    $creationPoints = 10;
    $badgeName = 'I CAN TALK';

    $achievementStorage = AchievementStorageFactory::getAchievementStorage();
    $pointsAchievement = $achievementStorage->getAchievement($user, 'CREATION');
    $badgeAchievement = $achievementStorage->getAchievement($user, $badgeName);

    if ($pointsAchievement instanceof Points) {
      $points = $pointsAchievement->getTotalPoints();
    }

    $this->assertSame($creationPoints, $points);
    $this->assertSame($badgeName, $badgeAchievement->getName());
    $this->assertCount(2, $achievementStorage->getAchievements($user));
  }

  public function testForumServiceAddingBadgeAndPointsOnMultipleFunctionsCalls(): void
  {
    $user = 'user1';

    AchievementStorageFactory::setAchievementStorage(new MemoryAchievementStorage());
    $forumService = new ForumServiceGamificationProxy(new ForumServiceGamification());

    // 5 CREATION pts + I CAN TALK
    $forumService->addTopic($user, 'firstTopic');

    // 3 PARTICIPATION pts + LET ME ADD
    $forumService->addComment($user, 'firstTopic', 'comment1');
    // 3 PARTICIPATION pts
    $forumService->addComment($user, 'firstTopic', 'comment2');

    $forumService->likeTopic($user, 'firstTopic', 'user2'); // 1 CREATION pts
    $forumService->likeTopic($user, 'secondTopic', 'user2'); // 1 CREATION pts
    $forumService->likeTopic($user, 'thirdTopic', 'user2'); // 1 CREATION pts

    // 1 PARTICIPATION pts
    $forumService->likeComment($user, 'firstTopic', 'comment1', 'user2');
    // 1 PARTICIPATION pts
    $forumService->likeComment($user, 'firstTopic', 'comment2', 'user2');
    // 1 PARTICIPATION pts
    $forumService->likeComment($user, 'firstTopic', 'comment3', 'user2');

    $creationPoints = 8;
    $participationPoints = 9;
    $talkBadgeName = 'I CAN TALK';
    $addBadgeName = 'LET ME ADD';

    $achievementStorage = AchievementStorageFactory::getAchievementStorage();
    $creationAchievement = $achievementStorage->getAchievement($user, 'CREATION');
    $participationAchievement = $achievementStorage->getAchievement($user, 'PARTICIPATION');
    $talkBadgeAchievement = $achievementStorage->getAchievement($user, $talkBadgeName);
    $addBadgeAchievement = $achievementStorage->getAchievement($user, $addBadgeName);

    if ($creationAchievement instanceof Points) {
      $totalCreationPoints = $creationAchievement->getTotalPoints();
    }

    if ($participationAchievement instanceof Points) {
      $totalParticipationPoints = $participationAchievement->getTotalPoints();
    }

    $this->assertSame($creationPoints, $totalCreationPoints);
    $this->assertSame($participationPoints, $totalParticipationPoints);
    $this->assertSame($talkBadgeName, $talkBadgeAchievement->getName());
    $this->assertSame($addBadgeName, $addBadgeAchievement->getName());

    // 2 Badges + 1 CREATION + 1 PARTICIPATION
    $this->assertCount(4, $achievementStorage->getAchievements($user));
  }

  public function testAchievementsNotBeingAddedOnForumServiceGamificationException(): void
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

    $forumServiceMock = $this->createMock(ForumServiceGamification::class);
    if ($forumServiceMock instanceof MockObject) {
      $forumServiceMock->method('addTopic')->will(
        $this->throwException(new \Exception('ERROR!'))
      );
      $forumServiceMock->method('addComment')->will(
        $this->throwException(new \Exception('ERROR!'))
      );
      $forumServiceMock->method('likeTopic')->will(
        $this->throwException(new \Exception('ERROR!'))
      );
      $forumServiceMock->method('likeComment')->will(
        $this->throwException(new \Exception('ERROR!'))
      );
    }

    $forumServiceProxy = new ForumServiceGamificationProxy($forumServiceMock);

    try {
      $forumServiceProxy->addTopic($user, 'topicName');
      $forumServiceProxy->addComment($user, 'topicName', 'comment');
      $forumServiceProxy->likeTopic($user, 'topicName', 'user2');
      $forumServiceProxy->likeComment($user, 'topicName', 'comment', 'user2');
    } catch (\Exception $_) {
    }

    $creationAchievement = $achievementStorage->getAchievement($user, 'CREATION');
    $talkAchievement = $achievementStorage->getAchievement($user, 'I CAN TALK');

    $this->assertTrue($creationAchievement instanceof NullAchievement);
    $this->assertTrue($talkAchievement instanceof NullAchievement);
  }
}
