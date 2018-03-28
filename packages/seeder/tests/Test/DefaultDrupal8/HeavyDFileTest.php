<?php

namespace surangapg\HeavydSeeder\Test\DefaultDrupal8;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use surangapg\HeavydSeeder\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;

/**
 * Class HeavyDFileTest
 *
 * Checks or the .heavyD file was generated and contains the correct data.
 *
 * @package test\Drupal8
 *
 * @covers seed:init
 */
class HeavyDFileTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the project dir exists and has some expected basic files.
   */
  public function testHeavyDirExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/.heavyd');
  }

  /**
   * Checks or the project dir exists and has some expected basic files.
   */
  public function testHeavyFileExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/.heavyd.yml');
  }

  /**
   * Checks or the heavyD composer was installed correctly.
   */
  public function testHeavyComposerLockExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/.heavyd/composer.lock');
  }
}