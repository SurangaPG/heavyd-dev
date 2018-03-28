<?php

namespace surangapg\HeavydSeeder\Test\DefaultDrupal8;

use PHPUnit\Framework\TestCase;
use surangapg\HeavydSeeder\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class HeavyDFileTest
 *
 * Checks or the .heavyD file was generated and contains the correct data.
 *
 * @package test\Drupal8
 *
 * @covers seed:init
 */
class BuildXmlTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the heavyd.project.xml exists.
   */
  public function testBuildHeavyDProjectXmlExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/build.xml');
  }
}