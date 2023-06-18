<?php
namespace Deployer;

require 'recipe/yii2-app-basic.php';

// Project name
set('application', 'app_name');

// Project repository
set('repository', 'git@github.com.vendor/repo.git');

// Shared files/dirs between deploys 
add('shared_files', [
    '.env',
]);
add('shared_dirs', [
    '/runtime'
]);

// Writable dirs by web server 
add('writable_dirs', []);

// Hosts
host('server name or ip')
    ->multiplexing(false)
    ->set('deploy_path', '/home/project_folder'')
    ->stage('production')
    ->user('debian');

// Tasks

task('change:permissions', function () {
    run('sudo chmod -R 777 /home/project_folder/current/runtime');
    run('sudo chmod -R 777 /home/project_folder/current/web/assets');
});

after('deploy', 'change:permissions');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

task('reload:php-fpm', function () {
    run('sudo /etc/init.d/php7.4-fpm reload');
});

after('deploy', 'reload:php-fpm');
