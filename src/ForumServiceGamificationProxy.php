<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

class ForumServiceGamificationProxy implements ForumService
{
  private ForumService $forumService;

  public function __construct(ForumService $service)
  {
    $this->forumService = $service;
  }
  private function addBadge(string $user, string $badgeName): void
  {
    $badge = MemoryAchievementStorage::getAchievement($user, $badgeName);
    // Add achievement if it doesn't already exist
    if ($badge instanceof NullAchievement) {
      MemoryAchievementStorage::addAchievement($user, new Badge($badgeName));
    }
  }

  private function addPoints(string $user, string $achievementName, int $points): void
  {
    $achievement = MemoryAchievementStorage::getAchievement($user, $achievementName);

    if ($achievement instanceof NullAchievement) {
      MemoryAchievementStorage::addAchievement(
        $user,
        new Points($achievementName, $points)
      );
    } else if ($points instanceof Points) {
      $points->addPoints($points);
    }
  }

  public function addTopic(string $user, string $topic): void
  {
    $this->forumService->addTopic($user, $topic);

    $this->addPoints($user, 'CREATION', 5);
    $this->addBadge($user, 'I CAN TALK');
  }

  public function addComment(string $user, string $topic, string $comment): void
  {
    $this->forumService->addComment($user, $topic, $comment);

    $this->addPoints($user, 'PARTICIPATION', 3);
    $this->addBadge($user, 'LET ME ADD');
  }

  public function likeTopic(string $user, string $topic, string $topicUser): void
  {
    $this->forumService->likeTopic($user, $topic, $topicUser);

    $this->addPoints($user, 'PARTICIPATION', 1);
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

    $this->addPoints($user, 'PARTICIPATION', 1);
  }
}
