<?php
namespace Deployer;

require 'recipe/common.php';
require 'recipe/rsync.php';

set('ssh_type', 'native');
set('ssh_multiplexing', true);

// Project name
set('application', 'heavyd_documentation');

// Main rsync source.
set('rsync_src', __DIR__ . '/docs/generated');

// Project repository
set('repository', 'https://suranga_panagamuwa_gamage@bitbucket.org/webct/heavyd-dev.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

set('shared_dirs', [
  'versions'
]);

// Writable dirs by web server 
set('writable_dirs', []);

// Hosts
host('webct-web1.level27.be')
  ->user('vd8418')
  ->stage('docs')
  ->port(22)
  ->forwardAgent(true)
  ->multiplexing(true)
  ->addSshOption('UserKnownHostsFile', '/dev/null')
  ->addSshOption('StrictHostKeyChecking', 'no')
  ->set('deploy_path', '~/heavyd-docs');

// Tasks
desc('Deploy documentation');
task('deploy-dev', [
  'deploy:info',
  'deploy:prepare',
  'deploy:lock',
  'deploy:release',
  'build:main-docs',
  'build:dev-docs',
  'rsync',
  'deploy:shared',
  'versions:update-dev',
  'deploy:writable',
  'deploy:clear_paths',
  'deploy:symlink',
  'deploy:unlock',
  'cleanup',
  'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Build Tasks
desc('Generate the main docs.');
task('build:main-docs', function() {
  runLocally(__DIR__ . '/vendor/bin/phing documentation:generate-main -buildfile build.docs.xml' );
});

desc('Generate the dev docs.');
task('build:dev-docs', function() {
  runLocally(__DIR__ . '/vendor/bin/phing documentation:generate-dev -buildfile build.docs.xml' );
});

// Deploy Tasks
desc('Update the dev archive to use the newly generated item.');
task('versions:update-dev', function() {
  run('echo {{release_path}}');
  run('rsync -vr --delete {{release_path}}/dev/ {{release_path}}/versions/dev/');
});

// @TODO Add a system to move the dev docs to a versioned folder (under /versions/TAG).
