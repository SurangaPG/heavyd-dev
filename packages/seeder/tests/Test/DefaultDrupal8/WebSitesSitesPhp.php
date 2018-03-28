<?php

namespace surangapg\HeavydSeeder\Test\DefaultDrupal8;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use surangapg\HeavydSeeder\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;

/**
 * Class TestsTest
 */
class WebSitesSitesPhp extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the web/sites/sites.php file exists.
   */
  public function testPropertiesDirExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/web/sites/sites.php');
  }
}
