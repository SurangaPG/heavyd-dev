<?php
namespace Deployer;

require 'recipe/common.php';
require 'recipe/rsync.php';

set('ssh_type', 'native');
set('ssh_multiplexing', true);

// Project name
set('application', 'heavyd_documentation');

// Main rsync source.
set('rsync_src', __DIR__ . '/docs/artifact');

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
  'rsync',
  'deploy:shared',
  'deploy:writable',
  'deploy:clear_paths',
  'deploy:symlink',
  'deploy:unlock',
  'cleanup',
  'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');



// @TODO Add a system to move the dev docs to a versioned folder (under /versions/TAG).
