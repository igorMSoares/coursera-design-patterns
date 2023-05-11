<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

class AchievementStorageFactory
{
  protected static ?AchievementStorage $storageInstance = null;
  static function getAchievementStorage(): AchievementStorage
  {
    if (!self::$storageInstance)
      throw new \Exception('No AchievementStorage has been set.\n');

    return self::$storageInstance;
  }

  static function setAchievementStorage(AchievementStorage $a): void
  {
    self::$storageInstance = $a;
  }
}
