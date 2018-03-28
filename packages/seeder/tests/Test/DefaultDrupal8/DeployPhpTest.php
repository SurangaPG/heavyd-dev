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
class DeployPhpTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the heavyd.project.xml exists.
   */
  public function testDeployPhpTestExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/deploy.php');
  }
}