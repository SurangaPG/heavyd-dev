<?php

require_once "phing/Task.php";

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

/**
 * Class SitesGenerateDirsTask
 *
 * Will prepare a number of directories based on the information in the seed.yml.
 */
class SitesGenerateDirsTask extends Task {

  /**
   * File to write the data to.
   *
   * @var string
   */
  protected $buildLocation;

  /**
   * Seedfile to source the data from.
   *
   * @var string
   */
  protected $seedFile;

  /**
   * Location for the template files.
   *
   * @var string
   */
  protected $templateLocation;

  /**
   * The init method: Do init steps.
   */
  public function init() {
    // nothing to do here
  }

  /**
   * The main entry point method.
   */
  public function main() {

    $fs = new Filesystem();
    $seedProperties = Yaml::parse(file_get_contents($this->getSeedFile()));

    // If no sites were specified.
    if (!isset($seedProperties['sites'])) {
      return;
    }

    // Otherwise generate one item for every one of the sites.
    foreach ($seedProperties['sites'] as $site => $info) {

      // Folder under web/sites
      if (!file_exists($this->getBuildLocation() . '/web/sites/' . $site)) {
        $fs->mkdir($this->getBuildLocation() . '/web/sites/' . $site);
      }

      // Folder under etc/sites
      if (!file_exists($this->getBuildLocation() . '/etc/site/' . $site)) {
        $fs->mkdir($this->getBuildLocation() . '/etc/site/' . $site);
      }

      // Folder under etc/site/NAME/translations
      if (!file_exists($this->getBuildLocation() . '/etc/site/' . $site . '/translations')) {
        $fs->mkdir($this->getBuildLocation() . '/etc/site/' . $site . '/translations');
        $fs->touch($this->getBuildLocation() . '/etc/site/' . $site . '/translations/.gitkeep');
      }

      // Folder under etc/site/NAME/config
      if (!file_exists($this->getBuildLocation() . '/etc/site/' . $site . '/config')) {
        $fs->mkdir($this->getBuildLocation() . '/etc/site/' . $site . '/config');
        $fs->touch($this->getBuildLocation() . '/etc/site/' . $site . '/config/.gitkeep');
      }

      // Folder under etc/site/NAME/properties
      if (!file_exists($this->getBuildLocation() . '/etc/site/' . $site . '/properties')) {
        $fs->mkdir($this->getBuildLocation() . '/etc/site/' . $site . '/properties');
        $fs->touch($this->getBuildLocation() . '/etc/site/' . $site . '/properties/.gitkeep');
        $fs->dumpFile($this->getBuildLocation() . '/etc/site/' . $site . '/properties/project.yml', Yaml::dump(['active' => ['site' => $site]]));
      }

      // Copy the settings.php file.
      $fs->copy(
        $this->getTemplateLocation() . '/site-templates/default.settings.php' ,
        $this->getBuildLocation() . '/web/sites/' . $site . '/settings.php'
      );

      $fs->copy(
        $this->getTemplateLocation() . '/site-templates/default.services.yml' ,
        $this->getBuildLocation() . '/web/sites/' . $site . '/services.yml'
      );

      $configProfile = isset($info['config-profile']) ? $info['config-profile'] : 'default';
      // Activate a standard config profile.
      $fs->mirror($this->templateLocation . '/config-profiles/' . $configProfile,  $this->getBuildLocation() . '/etc/site/' . $site . '/config');
    }
  }

  /**
   * @return string
   */
  public function getSeedFile() {
    return $this->seedFile;
  }

  /**
   * @param $seedFile
   */
  public function setSeedFile($seedFile) {
    $this->seedFile = $seedFile;
  }

  /**
   * @return string
   */
  public function getBuildLocation() {
    return $this->buildLocation;
  }

  /**
   * @param string $buildLocation
   */
  public function setBuildLocation($buildLocation) {
    $this->buildLocation = $buildLocation;
  }

  /**
   * @return string
   */
  public function getTemplateLocation() {
    return $this->templateLocation;
  }

  /**
   * @param $templateLocation
   */
  public function setTemplateLocation($templateLocation) {
    $this->templateLocation = $templateLocation;
  }
}

?>