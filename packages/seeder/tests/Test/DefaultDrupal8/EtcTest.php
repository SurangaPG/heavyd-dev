<?php

namespace surangapg\HeavydSeeder\Test\DefaultDrupal8;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use surangapg\HeavydSeeder\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;

/**
 * Class EtcEnvTest
 *
 * Checks that the various expected environment directories have been added.
 *
 * @package test\Drupal8
 *
 * @covers seed:init
 */
class EtcTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the etc folder exists.
   */
  public function testEtcEnvDirExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/etc');
    $subDir = glob($this->getProjectDirectory() . '/etc/*', GLOB_ONLYDIR);
    $this->assertEquals(4, count($subDir), 'Only 4 subdirs should exist.');
  }
}