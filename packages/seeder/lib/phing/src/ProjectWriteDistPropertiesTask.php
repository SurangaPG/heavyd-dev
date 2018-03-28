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
class ProjectWriteDistPropertiesTask extends Task {

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
    $generatedProperties = [];

    $generatedProperties['label'] = $seedProperties['project_label'];
    $generatedProperties['machineName'] = $seedProperties['project_name'];
    $generatedProperties['group'] = $seedProperties['project_group'];
    $generatedProperties['basePath'] = '${current.basePath}';
    $generatedProperties['type'] = $seedProperties['project_type'];
    $generatedProperties['repository']['main'] = $seedProperties['project_git_repository'];
    $generatedProperties['php'] = $seedProperties['project_php_version'];

    // Add platform information.
    if (isset($generatedProperties['platform'])) {
      $generatedProperties['platform'] = $seedProperties['platform'];
    }

    $fs->dumpFile($this->getTargetFile(), Yaml::dump($generatedProperties, 5, 2));
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