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
class EtcEnvTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the etc folder exists.
   */
  public function testEtcEnvDirExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env');
  }

  /**
   * Checks or the pipeline basic files exist.
   */
  public function testEtcEnvDirDockerExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env/pipeline');

    // Only 3 files should exist.
    $propertyFiles = glob($this->getProjectDirectory() . '/etc/env/pipeline/properties/*.yml');
    $this->assertEquals(3, count($propertyFiles), 'Only 3 files should exist.');

    // Check the actual file names.
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env/pipeline/properties/db.yml');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env/pipeline/properties/host.yml');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env/pipeline/properties/project.yml');

    // Check that the settings.env file was added.
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env/pipeline/settings.env.php');
  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcEnvDirPipelineExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env/docker');

    // Only 3 files should exist.
    $propertyFiles = glob($this->getProjectDirectory() . '/etc/env/docker/properties/*.yml');
    $this->assertEquals(3, count($propertyFiles), 'Only 3 files should exist.');

    // Check the actual file names.
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env/docker/properties/docker.yml');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env/docker/properties/host.yml');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env/docker/properties/project.yml');

    // Check that the settings.env file was added.
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env/docker/settings.env.php');
  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcEnvDirEnvFileExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env/env-file');

    // Only 3 files should exist.
    $propertyFiles = glob($this->getProjectDirectory() . '/etc/env/env-file/properties/*.yml');
    $this->assertEquals(1, count($propertyFiles), 'Only 1 file should exist.');

    // Check the actual file.
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env/env-file/properties/project.yml');

    // Check that the settings.env file was added.
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env/env-file/settings.env.php');
  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcEnvDirLocalhostExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env/localhost');

    // Only 3 files should exist.
    $propertyFiles = glob($this->getProjectDirectory() . '/etc/env/localhost/properties/*.yml');
    $this->assertEquals(3, count($propertyFiles), 'Only 3 files should exist.');

    // Check the actual file.
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env/localhost/properties/project.yml');

    // Check that the settings.env file was added.
    $this->assertFileExists($this->getProjectDirectory() . '/etc/env/localhost/settings.env.php');
  }
}