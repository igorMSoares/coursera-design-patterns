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

  public function addTopic(string $user, string $topic): void
  {
    $this->forumService->addTopic($user, $topic);

    $this->achievementStorage->addAchievement($user, new Badge('I CAN TALK'));
    $this->achievementStorage->addAchievement($user, new Points('CREATION', 5));
  }

  public function addComment(string $user, string $topic, string $comment): void
  {
    $this->forumService->addComment($user, $topic, $comment);

    $this->achievementStorage->addAchievement($user, new Badge('LET ME ADD'));
    $this->achievementStorage->addAchievement($user, new Points('PARTICIPATION', 3));
  }

  public function likeTopic(string $user, string $topic, string $topicUser): void
  {
    $this->forumService->likeTopic($user, $topic, $topicUser);

    $this->achievementStorage->addAchievement($user, new Points('CREATION', 1));
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
  }
}
