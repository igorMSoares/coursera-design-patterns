<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

foreach (glob("src/*.php") as $filename) {
  require_once $filename;
}

function printAchievementsList(array $achievementsList): void
{
  // Prints all the achievements added to this user
  echo "\n******** Conquistas ********\n";
  foreach ($achievementsList as $achievement) {
    $name = $achievement->getName();
    echo "$name";

    if ($achievement instanceof Points) {
      $points = $achievement->getTotalPoints();
      echo " [$points Pontos]\n";
    } else if ($achievement instanceof Badge) {
      echo " [Badge]\n";
    }
  }
  echo "****************************\n\n";
}

function printAchievementsListHeader(
  $i,
  $addTopic,
  $addComment,
  $likeTopic,
  $likeComment
) {
  echo "[addTopic: x$addTopic |";
  echo " addComment: x$addComment |";
  echo " likeTopic: x$likeTopic |";
  echo " likeComment: x$likeComment]";
  echo " ($i)";
}

// Initialize achievement storage
AchievementStorageFactory::setAchievementStorage(new MemoryAchievementStorage());
$achievementStorage = AchievementStorageFactory::getAchievementStorage();

// Create observers
$creationAchievementObserver =
  new CreationAchievementObserver($achievementStorage);
$participationAchievementObserver =
  new ParticipationAchievementObserver($achievementStorage);

// Attach observers to storage
$achievementStorage
  ->attachAchievementObserver($creationAchievementObserver);
$achievementStorage
  ->attachAchievementObserver($participationAchievementObserver);

// Create forum service proxy
$forumServiceProxy =
  new ForumServiceGamificationProxy(new ForumServiceGamification());

$user1 = 'user1';
$user2 = 'user2';
$topic = 'topic';
$comment = 'comment';

$forumServiceFunctions = array(
  function ($user, $topic) use ($forumServiceProxy) {
    $forumServiceProxy->addTopic($user, $topic);
  },
  function ($user, $topic, $comment) use ($forumServiceProxy) {
    $forumServiceProxy->addComment($user, $topic, $comment);
  },
  function ($user, $topic, $topicUser) use ($forumServiceProxy) {
    $forumServiceProxy->likeTopic($user, $topic, $topicUser);
  },
  function ($user, $topic, $comment, $commentUser) use ($forumServiceProxy) {
    $forumServiceProxy->likeComment($user, $topic, $comment, $commentUser);
  }
);

/* Simulates 100 random forum service's actions
 * Play around with the number of actions or
 * comment out any of the case options to
 * see how it will reflect in the user's final achievements */
$addTopic = 0;
$addComment = 0;
$likeTopic = 0;
$likeComment = 0;
for ($i = 0; $i < 100; $i++) {
  $functionId = random_int(0, 3);

  switch ($functionId) {
    case 0: // addTopic()
      $forumServiceFunctions[0]($user1, $topic);
      $addTopic++;
      break;
    case 1: // addComment()
      $forumServiceFunctions[1]($user1, $topic, $comment);
      $addComment++;
      break;
    case 2: // likeTopic()
      $forumServiceFunctions[2]($user1, $topic, $user2);
      $likeTopic++;
      break;
    case 3: // likeComment()
      $forumServiceFunctions[3]($user1, $topic, $comment, $user2);
      $likeComment++;
      break;
  }
  if ($i % 40 == 0) {
    $achievementsList = $achievementStorage->getAchievements($user1);
    printAchievementsListHeader(
      $i,
      $addTopic,
      $addComment,
      $likeTopic,
      $likeComment
    );
    printAchievementsList($achievementsList);
  }
}
$achievementsList = $achievementStorage->getAchievements($user1);
printAchievementsListHeader(
  $i,
  $addTopic,
  $addComment,
  $likeTopic,
  $likeComment
);
printAchievementsList($achievementsList);
