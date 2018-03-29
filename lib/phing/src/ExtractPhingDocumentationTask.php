<?php

require_once "phing/Task.php";

/**
 * Class ExtractPhingDocumentationTask
 *
 * Extract all the pieces from a phing xml file and write them out to html
 * snippets.
 */
class ExtractPhingDocumentationTask extends Task {

  /**
   * @var string
   *   Main directory to place the output.
   */
  private $outputDir;

  /**
   * @var string
   *   The main task file for the project.
   */
  private $mainTaskFile;

  /**
   * @var string
   *   The dir with all the phing subtasks.
   */
  private $subTaskDir;

  /**
   * @var string
   *   The dir with all the partial html files.
   */
  private $htmlPartialsDir;

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

    $mainTargets = $this->getTargetInfoFromFile($this->getMainTaskFile());

    // Generate a tree based on the main parts for this item. E.g a target
    // named project:install-project should generate the following output:
    // /project/install-project/_main.html
    // These partials will be aggregated into a full fledged html page later.
    foreach ($mainTargets as $target => $targetElement) {

      // Don't write out the help. Since it's not very useful.
      if ($target == 'help') {
        continue;
      }

      $subDirs = explode(':', $target);
      $root = '/';
      foreach ($subDirs as $subDir) {
        $dirName = $this->getOutputDir() . $root . $subDir;
        if (!file_exists($dirName)) {
          mkdir($dirName);
        }

        // For now, just write out an empty page to ensure the page structure
        // is respected.
        // If this is the endpoint the data will be overwritten by the next step.
        file_put_contents($dirName  . '/_title.html', $subDir  . ' (group)');

        $root .= $subDir . '/';
      }

      $output = $target;
      file_put_contents($this->getOutputDir() . $root  . '_title.html', $output);

      // Generate the actual html part to be aggregated later.
      $outputFile = $this->getOutputDir() . $root  . '_main.html';
      if (!file_exists($outputFile)) {
        touch($outputFile);
      }

      // Generate the output for the element.
      $this->outputElementContent($outputFile, $targetElement);
    }
  }

  /**
   * Write the data about a single element to a file.
   *
   * @param string $fileName
   *   File to write to.
   * @param \SimpleXMLElement $element
   *   Simple xml element.
   */
  protected function outputElementContent($fileName, SimpleXMLElement $element) {
    $output = "<p>" . (string) $element->attributes()['description'] . "</p>";

    $subCalls = $element->xpath('phingcall');
    if (count($subCalls)) {

      $output .= "<h2>Subtargets</h2>\n";
      $output .= "<ul>\n";
      foreach ($subCalls as $subCall) {
        $subTargetName = (string) $subCall->attributes()['target'];
        $output .= "<li>\n";
        $output .= '<a href="'. $subTargetName .'">' . $subTargetName . '</a>';
        $output .= "</li>\n";
      }
      $output .= "</ul>\n";
    }

    $output .= "<h2>Raw code</h2>\n";
    $output .= "<code>\n";
    $output .= "<pre>     " . htmlentities($element->saveXML()) . "</pre>";
    $output .= "</code>\n";

    file_put_contents($fileName, $output);
  }

  /**
   * Load an xml file and extract all the targets.
   *
   * @param string $xmlFile
   *   Location of an xml file.
   *
   * @return SimpleXMLElement[]
   *   Array with all the targets.
   */
  protected function getTargetInfoFromFile($xmlFile) {
    $xml = new SimpleXMLElement(file_get_contents($xmlFile));
    $xml = $xml->xpath('target');
    $return = [];
    foreach ($xml as $target) {
      $return[(string) $target->attributes()['name']] = $target;
    }

    return $return;
  }

  /**
   * @return string
   */
  public function getHtmlPartialsDir() {
    return $this->htmlPartialsDir;
  }

  /**
   * @return string
   */
  public function getMainTaskFile() {
    return $this->mainTaskFile;
  }

  /**
   * @return string
   */
  public function getOutputDir() {
    return $this->outputDir;
  }

  /**
   * @return string
   */
  public function getSubTaskDir() {
    return $this->subTaskDir;
  }

  /**
   * @param $htmlPartialsDir
   */
  public function setHtmlPartialsDir($htmlPartialsDir) {
    $this->htmlPartialsDir = $htmlPartialsDir;
  }

  /**
   * @param $mainTaskFile
   */
  public function setMainTaskFile($mainTaskFile) {
    $this->mainTaskFile = $mainTaskFile;
  }

  /**
   * @param $outputDir
   */
  public function setOutputDir($outputDir) {
    $this->outputDir = $outputDir;
  }

  /**
   * @param $subTaskDir
   */
  public function setSubTaskDir($subTaskDir) {
    $this->subTaskDir = $subTaskDir;
  }
}

?>