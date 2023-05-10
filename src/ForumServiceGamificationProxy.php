<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

class ForumServiceGamificationProxy implements ForumService
{
  private ForumService $forumService;
  private AchievementStorage $achievementStorage;

  public function __construct(ForumService $service)
  {
    $this->forumService = $service;
    $this->achievementStorage = AchievementStorageFactory::getAchievementStorage();
  }

  private function addBadge(string $user, string $badgeName): void
  {
    $achievementStorage = AchievementStorageFactory::getAchievementStorage();
    $badgeAchievement = $achievementStorage->getAchievement($user, $badgeName);

    // Add achievement if it doesn't already exist
    if ($badgeAchievement instanceof NullAchievement) {
      $achievementStorage->addAchievement($user, new Badge($badgeName));
    }
  }

  private function addPoints(string $user, string $achievementName, int $points): void
  {
    $achievementStorage = AchievementStorageFactory::getAchievementStorage();
    $pointsAchievement = $achievementStorage->getAchievement($user, $achievementName);

    if ($pointsAchievement instanceof NullAchievement) {
      // Create new achievement with this name
      $achievementStorage->addAchievement(
        $user,
        new Points($achievementName, $points)
      );
    } else if ($pointsAchievement instanceof Points) {
      // Already exists an achievement with this name, so increment its points
      $pointsAchievement->addPoints($points);
    }
  }

  public function addTopic(string $user, string $topic): void
  {
    $this->forumService->addTopic($user, $topic);

    $this->achievementStorage->addAchievement($user, new Badge('I CAN TALK'));
    $this->achievementStorage->addAchievement($user, new Points('CREATION', 5));
    // $this->addPoints($user, 'CREATION', 5);
    // $this->addBadge($user, 'I CAN TALK');
  }

  public function addComment(string $user, string $topic, string $comment): void
  {
    $this->forumService->addComment($user, $topic, $comment);

    $this->achievementStorage->addAchievement($user, new Badge('LET ME ADD'));
    $this->achievementStorage->addAchievement($user, new Points('PARTICIPATION', 3));
    // $this->addPoints($user, 'PARTICIPATION', 3);
    // $this->addBadge($user, 'LET ME ADD');
  }

  public function likeTopic(string $user, string $topic, string $topicUser): void
  {
    $this->forumService->likeTopic($user, $topic, $topicUser);

    $this->achievementStorage->addAchievement($user, new Points('CREATION', 1));
    // $this->addPoints($user, 'CREATION', 1);
  }

  public function likeComment(
    string $user,
    string $topic,
    string $comment,
    string $commentUser
  ): void {
    $this->forumService->likeComment(
      $user,
      $topic,
      $comment,
      $commentUser
    );

    $this->achievementStorage->addAchievement($user, new Points('PARTICIPATION', 1));
    // $this->addPoints($user, 'PARTICIPATION', 1);
  }
}
