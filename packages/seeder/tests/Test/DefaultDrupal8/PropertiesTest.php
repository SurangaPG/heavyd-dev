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
class PropertiesTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the etc folder exists.
   */
  public function testPropertiesDirExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/properties');
    $this->assertFileExists($this->getProjectDirectory() . '/properties/dist');

    // Only 3 files should exist.
    $propertyFiles = glob($this->getProjectDirectory() . '/properties/dist/*.yml');
    $this->assertEquals(7, count($propertyFiles), 'Only 7 files should exist.');

    $this->assertFileExists($this->getProjectDirectory() . '/properties/dist/behat.yml');
    $this->assertFileExists($this->getProjectDirectory() . '/properties/dist/bin.yml');
    $this->assertFileExists($this->getProjectDirectory() . '/properties/dist/dir.yml');
    $this->assertFileExists($this->getProjectDirectory() . '/properties/dist/githook.yml');
    $this->assertFileExists($this->getProjectDirectory() . '/properties/dist/jira.yml');
    $this->assertFileExists($this->getProjectDirectory() . '/properties/dist/project.yml');
    $this->assertFileExists($this->getProjectDirectory() . '/properties/dist/server.yml');
  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcSiteDirDefaultExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/etc/site/default');



    // Check the actual file names.
    $this->assertFileExists($this->getProjectDirectory() . '/etc/site/default/config');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/site/default/properties');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/site/default/translations');

    // Check the property file.
    $propertyFiles = glob($this->getProjectDirectory() . '/etc/site/default/properties/*.yml');
    $this->assertEquals(1, count($propertyFiles), 'Only 1 property file should exist.');
  }
}