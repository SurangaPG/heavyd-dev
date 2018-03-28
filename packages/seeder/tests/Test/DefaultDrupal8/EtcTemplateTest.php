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
class EtcTemplateTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the etc folder exists.
   */
  public function testEtcTemplateDirExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/etc/template');

    $this->assertListOfSubDirectories('etc/template/*', ['docker-compose.template.yml']);
  }
}