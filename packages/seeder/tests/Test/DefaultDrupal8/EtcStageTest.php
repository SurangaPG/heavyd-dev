<?php

namespace surangapg\HeavydSeeder\Test\DefaultDrupal8;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use surangapg\HeavydSeeder\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;

/**
 * Class EtcStageTest
 *
 * Checks that the various expected stage directories have been added.
 */
class EtcStageTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the etc folder exists.
   */
  public function testStageDirExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage');
  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcStageDirExists() {

    // Only 3 files should exist.
    $this->assertListOfSubDirectories('etc/stage/*',
      ['acc', 'dev', 'install', 'prod', 'test'],
      GLOB_ONLYDIR
    );

  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcStageDirAccExists() {

    // Check the property file.
    $propertyFiles = glob($this->getProjectDirectory() . '/etc/stage/acc/properties/*.yml');
    $this->assertEquals(1, count($propertyFiles), 'Only 1 property file should exist.');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/acc/settings.stage.php');

    // 3 types of default content should have been injected.
    $this->assertListOfSubDirectories('etc/stage/acc/default_content/*', ['node', 'user', 'paragraph'], GLOB_ONLYDIR);
  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcStageDirDevExists() {

    // Check the property file.
    $propertyFiles = glob($this->getProjectDirectory() . '/etc/stage/dev/properties/*.yml');
    $this->assertEquals(1, count($propertyFiles), 'Only 1 property file should exist.');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/dev/settings.stage.php');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/dev/services.stage.yml');

    // 3 types of default content should have been injected.
    $this->assertListOfSubDirectories('etc/stage/dev/default_content/*', ['node', 'user', 'paragraph'], GLOB_ONLYDIR);
  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcStageDirInstallExists() {

    // Check the property file.
    $propertyFiles = glob($this->getProjectDirectory() . '/etc/stage/install/properties/*.yml');
    $this->assertEquals(1, count($propertyFiles), 'Only 1 property file should exist.');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/install/settings.stage.php');
  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcStageDirProdExists() {

    // Check the property file.
    $propertyFiles = glob($this->getProjectDirectory() . '/etc/stage/prod/properties/*.yml');
    $this->assertEquals(1, count($propertyFiles), 'Only 1 property file should exist.');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/prod/settings.stage.php');

    // 3 types of default content should have been injected.
    $this->assertListOfSubDirectories('etc/stage/prod/default_content/*', ['node', 'user', 'paragraph'], GLOB_ONLYDIR);
  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcStageDirTestExists() {

    // Check the property file.
    $propertyFiles = glob($this->getProjectDirectory() . '/etc/stage/test/properties/*.yml');
    $this->assertEquals(1, count($propertyFiles), 'Only 1 property file should exist.');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/test/settings.stage.php');

    // 3 types of default content should have been injected.
    $this->assertListOfSubDirectories('etc/stage/test/default_content/*', ['node', 'user', 'paragraph'], GLOB_ONLYDIR);
  }
}
