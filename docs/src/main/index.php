<!DOCTYPE html>
<html>
<head>
  <title>HeavyD Documentation</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
  <h1>Heavy Duty Drupal setup</h1>
  <p>Welcome to the alpha version of the heavyD platform documentation. An opinionated devops setup for Drupal 8 that is quickly spiraling out of control.</p>
  <p>It's not yet stable, but keep an eye on this page if it sparked your interest.</p>

  <div class="card m-b-3">
    <div class="card-body">
      <h3 class="card-title">Dev version</h3>
      <p class="card-text">Find all the documentation about the dev version here.</p>
      <a href="versions/dev/index.html">Dev version documentation</a>
    </div>
  </div>

  <h2>Older versions</h2>
  <?php
  // Crude implementation to display all the older versions.
  $versions = glob(__DIR__ . '/versions/*/index.html');
  $versions = array_reverse($versions);
  $versionInfo = [];

  foreach ($versions as $version) {
    $relativeFile = str_replace(__DIR__, '', $version);
    $label = basename(dirname($version));

    if ($label != 'dev') {
      $versionInfo[] = [
          'url' => $relativeFile,
          'label' => basename(dirname($version)),
      ];
    }
  }
  ?>
  <table class="table">
    <thead class="thead-light">
      <tr>
        <td>Version</td>
      </tr>
    </thead>
    <tbody class="table-striped">
      <?php foreach ($versionInfo as $versionItem): ?>
        <tr>
          <td>
            <a href="<?php print $versionItem['url']; ?>"><?php print $versionItem['label']; ?></a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

</body>
</html>
