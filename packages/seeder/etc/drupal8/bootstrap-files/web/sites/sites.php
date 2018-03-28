<?php

$sites = [];

if (file_exists(__DIR__. '/sites.stage.php')) {
  require_once __DIR__ . '/sites.stage.php';
}
