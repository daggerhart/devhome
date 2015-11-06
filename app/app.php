<?php

// debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// constants
define( 'APP_PATH', __DIR__ );

// requirements
require_once APP_PATH . '/includes/functions.php';

call_user_func(function() {
    $settings    = get_settings( APP_PATH . '/config/settings.yaml');
    $discoveries = discover_projects($settings);

    print template('home.tpl.php', [
        'utils'       => $settings['utils'],
        'projects'    => $settings['projects'],
        'discoveries' => $discoveries,
        'settings'    => $settings,
    ]);
});
