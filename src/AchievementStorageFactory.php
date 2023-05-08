<?php

declare(strict_types=1);

namespace Igormsoares\CourseraDesignPatterns;

class AchievementStorageFactory
{
  protected ?AchievementStorage $storageInstance;
  static function getAchievementStorage(): AchievementStorage|null
  {
    return self::$storageInstance;
  }

  static function setAchievementStorage(AchievementStorage $a): void
  {
    if (!self::$storageInstance) self::$storageInstance = $a;
  }
}
