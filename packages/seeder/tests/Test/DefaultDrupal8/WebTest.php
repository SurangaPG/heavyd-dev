<?php

namespace surangapg\HeavydSeeder\Test\DefaultDrupal8;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use surangapg\HeavydSeeder\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;

/**
 * Class TestsTest
 */
class WebTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the etc folder exists.
   */
  public function testPropertiesDirExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/web');

    // Only 3 files should exist.
    $subDirs = glob($this->getProjectDirectory() . '/web/*', GLOB_ONLYDIR);
    $this->assertEquals(5, count($subDirs), 'Only 5 subdirs should exist.');
  }
}
