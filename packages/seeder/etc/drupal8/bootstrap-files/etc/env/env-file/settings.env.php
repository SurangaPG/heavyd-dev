<?php

// Generate a dummy local hash
$dummy_hash = [];
exec('whoami', $dummy_hash);
$settings['hash_salt'] = base64_encode($dummy_hash[0] . __DIR__);

// Read the machine name from the current dir
$baseSiteName = basename(__DIR__);

/*
 * Read all the other data from the db properties.
 */
$envFile = dirname(dirname(dirname(__DIR__))) . '/.env';

// Get the files from the .env file
$envConf = base64_decode(file_get_contents($envFile));
$envConf = json_decode($envConf, TRUE);
$siteConf = $envConf[$baseSiteName];

if (isset($siteConf['databases'])) {
  $databases = $siteConf['databases'];
}

$settings['hash_salt'] = $siteConf['hash_salt'];
