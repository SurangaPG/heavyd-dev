<?php

require_once "phing/Task.php";

use Symfony\Component\Yaml\Yaml;

/**
 * Class ServerProvisionEnvFileTask
 *
 * Places the .env file on the server for the first time.
 */
class ServerProvisionEnvFileTask extends Task {

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

    $seedProperties = Yaml::parse(file_get_contents($this->getSeedFile()));

    if (!isset($seedProperties['servers'])) {
      return;
    }

    foreach ($seedProperties['servers'] as $serverKey => $properties) {
      if (isset($properties['credentials'])) {

        $site = isset($properties['server_site']) ? $properties['server_site'] : 'default';

        // Start by ensuring the shared dir exists.
        // @TODO Make this a bit more solid (maybe use deployer itself?)
        passthru(sprintf("ssh %s@%s 'mkdir -p %s/shared'", $properties['server_user'], $properties['server_host'], $properties['server_root']));

        // Set up the .env file.
        $envJson = [];
        $envJson[$site] = $properties['credentials'];
        if (!isset($envJson[$site]['hash_salt'])) {
          $php = new \surangapg\HeavydComponents\Crypt\Php();
          $envJson[$site]['hash_salt'] = $php->generate();
        }
        $envJson = json_encode($envJson, JSON_PRETTY_PRINT);
        $envJson = base64_encode($envJson);
        passthru(sprintf("ssh %s@%s 'echo %s > %s/shared/.env'", $properties['server_user'], $properties['server_host'], $envJson, $properties['server_root']));
      }
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
}

?>