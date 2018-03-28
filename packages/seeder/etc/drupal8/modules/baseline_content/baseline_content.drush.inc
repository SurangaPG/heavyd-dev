<?php
/**
 * @file Contains the code to generate the custom drush commands.
 */
/**
 * Implements hook_drush_command().
 */
function baseline_content_drush_command() {
  $items = array();
  $items['clean-imported-default-content'] = [
    'description' => 'Cleans up some items after importing default content.',
    'drupal dependencies' => ['baseline_content'],
  ];
  return $items;
}
/**
 * Call back function drush_custom_drush_command_say_hello()
 * The call back function name in the  following format
 *   drush_{module_name}_{item_id_for_command}()
 */
function drush_baseline_content_clean_imported_default_content() {
  drush_print('Updating some default content oddities.');

  /** @var \Drupal\file\FileInterface[] $files */
  $files = \Drupal\file\Entity\File::loadMultiple();

  // The location of the files is not set correctly when importing. Since this is
  // normally done by the form submit handlers. To remedy this we'll reset it
  // "manually" based on the data provided in the export which contains the
  // expected location in the file system.

  drush_print('Handling ' . count($files) . ' file(s).');
  foreach ($files as $file) {
    $file->setPermanent();

    // Get the location based on the export.
    $fileName = sprintf(drupal_get_path('module', 'baseline_content') . '/content/file/%s.json', $file->uuid());
    if (file_exists($fileName)) {
      $data = json_decode(file_get_contents($fileName));

      // Get the original location for the file.
      // e.g: http:\/\/werkhuys.mamp\/sites\/default\/files\/zalen\/klaslokaal-3-1.jpg
      $uri = $data->uri[0]->value;

      // Prevent trying to do this twice.
      if (strpos($uri, 'public://') === 0) {
        continue;
      }

      $uri = explode('/', $uri);

      array_shift($uri); // - http:
      array_shift($uri); // - NULL (due to //)
      array_shift($uri); // - NULL (due to //)
      array_shift($uri); // - sites
      array_shift($uri); // - default
      array_shift($uri); // - files

      array_pop($uri);

      $uri = implode('/', $uri);
      $uri = "public://" . $uri . '/' . $file->getFilename();
      // Is now the expected public://zalen/klaslokaal-3-1.jpg
      $file->setFileUri($uri);

      echo " Changed uri from " . $data->uri[0]->value . " to " . $uri . "\n";
    }

    $file->save();
  }

  /**
   * Very minimal helper to ensure the menu tree structure after importing.
   *
   * @TODO This is absolute minimal MVP and should be ported to a decent phing task at some point.
   */
  $menuContentLinks = \Drupal\menu_link_content\Entity\MenuLinkContent::loadMultiple();

  drush_print('Handling ' . count($menuContentLinks) . ' menu link(s).');
  foreach ($menuContentLinks as $menuContentLink) {
    $menuContentLink->save();
  }
}