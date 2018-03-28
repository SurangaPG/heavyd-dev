<?php

require_once "phing/Task.php";

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

/**
 * Class CleanExportedDataTask
 *
 * This task will take all the data in a dir and clean it up for use in a more
 * generic default content setup. Since the standard HAL export tends to use
 * the uri of the machine exporting it which we currently can't rely on.
 */
class ServerWriteDistPropertiesTask extends Task {

  /**
   * File to write the data to.
   *
   * @var
   */
  protected $targetFile;

  /**
   * Seedfile to source the data from.
   *
   * @var
   */
  protected $seedFile;

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

    $fs->touch($this->getTargetFile());

    $seedProperties = Yaml::parse(file_get_contents($this->getSeedFile()));
    $serverProperties = [];

    if (!isset($seedProperties['servers'])) {
      return;
    }

    foreach ($seedProperties['servers'] as $serverKey => $properties) {
      $serverProperties[$serverKey] = [
        'label' => isset($properties['server_label']) ? $properties['server_label'] : ucfirst($serverKey),
        'host' => $properties['server_host'],
        'user' => $properties['server_user'],
        'root' => $properties['server_root'],
        'stage' => $properties['server_stage'],
        'env' => $properties['server_env'],
        'hostedBy' => $properties['server_hosted_by'],
        'site' => isset($properties['server_site']) ? $properties['server_site'] : 'default',
      ];
    }

    $fs->dumpFile($this->getTargetFile(), Yaml::dump($serverProperties, 5, 2));
  }

  /**
   * @return string
   */
  public function getSeedFile() {
    return $this->seedFile;
  }

  /**
   * @return string
   */
  public function getTargetFile() {
    return $this->targetFile;
  }

  /**
   * @param $seedFile
   */
  public function setSeedFile($seedFile) {
    $this->seedFile = $seedFile;
  }

  /**
   * @param $targetFile
   */
  public function setTargetFile($targetFile) {
    $this->targetFile = $targetFile;
  }

}

?>