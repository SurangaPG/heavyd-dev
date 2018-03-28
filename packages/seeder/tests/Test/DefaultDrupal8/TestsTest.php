<?php

namespace surangapg\HeavydSeeder\Test\DefaultDrupal8;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use surangapg\HeavydSeeder\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;

/**
 * Class TestsTest
 */
class TestsTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the etc folder exists.
   */
  public function testPropertiesDirExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/tests');

    // Only 3 files should exist.
    $subDirs = glob($this->getProjectDirectory() . '/tests/*', GLOB_ONLYDIR);
    $this->assertEquals(3, count($subDirs), 'Only 3 subdirs should exist.');

    $this->assertFileExists($this->getProjectDirectory() . '/tests/behat');
    $this->assertFileExists($this->getProjectDirectory() . '/tests/phpunit');
    $this->assertFileExists($this->getProjectDirectory() . '/tests/haunt');
  }
}