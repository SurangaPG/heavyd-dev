<?php

require_once "phing/Task.php";

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

/**
 * Class DrupalCleanseConfigTask
 *
 * Remove all uuid's etc from a set of exported config. Ensuring reimporting it
 * into another site doesn't result in a crazy amount of duplicate data.
 */
class SitesAddConfigTask extends Task {

  /**
   * @var Filesystem
   */
  protected $fs;

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
    $this->fs = new Filesystem();
    $seedProperties = Yaml::parse(file_get_contents($this->getSeedFile()));

    // If no sites were specified.
    if (!isset($seedProperties['sites'])) {
      return;
    }

    // Otherwise generate one item for every one of the sites.
    foreach ($seedProperties['sites'] as $site => $info) {
      $configProfile = isset($info['config-profile']) ? $info['config-profile'] : 'default';
      // Activate a standard config profile.
      $this->fs->mirror($this->templateLocation . '/config-profiles/' . $configProfile,  $this->getBuildLocation() . '/etc/site/' . $site . '/config');
      $this->cleanConfigDir($this->getBuildLocation() . '/etc/site/' . $site . '/config');
    }
  }

  /**
   * @param $dir
   */
  public function cleanConfigDir($dir) {
    // Find an handle all the yml files.
    $files = glob($dir . '/*.yml');

    foreach ($files as $file) {
      $this->handleFile($file);
    }
  }

  /**
   * Clean up a single file.
   *
   * @param $file
   */
  public function handleFile($file) {
    $data = Yaml::parse(file_get_contents($file));

    // Clean up uuid's.
    unset($data['uuid']);

    // Clean up the _core default hash.
    unset($data['_core']);


    $this->fs->dumpFile($file, Yaml::dump($data, 4, 2));
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