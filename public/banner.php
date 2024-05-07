<?php

namespace BannerProject;

error_reporting(1);

require_once '../load.php';

try {
    // get config
    $config = new Config();

    // set exception mode for mysqli for php < 8.1
    $mysqli_driver = new \mysqli_driver();
    $mysqli_driver->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

    // load data provider
    $mysqlProvider = new MySqlDataProvider($config->databaseHost, $config->databaseUser, $config->databasePassword, $config->databaseName);
    // get visitor information
    $visitorDto = (new ClientDataQuery())->getVisitorData();
    // run update visitor command
    (new UpdateVisitorCommand($mysqlProvider))->handle($visitorDto);
    // return banner image
    (new BannerImage(__DIR__.'/banner.png'))->render();

} catch (\Exception $e) {
    // write log
    file_put_contents(__DIR__.'/../log/error.log', $e->getMessage().PHP_EOL, FILE_APPEND);
    // return placeholder erro image
    (new BannerImage(__DIR__.'/error.png'))->render();
}