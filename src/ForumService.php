<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

interface ForumService
{
  public function addTopic(string $user, string $topic): void;
  public function addComment(string $user, string $topic, string $comment): void;
  public function likeTopic(string $user, string $topic, string $topicUser): void;
  public function likeComment(
    string $user,
    string $topic,
    string $comment,
    string $commentUser
  ): void;
}
