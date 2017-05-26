<?php
/**
 * An example logger client.
 *
 * @package Kount_Log
 * @author Kount <custserv@kount.com>
 * @version $Id$
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */

// require_once 'Kount/autoloader.php';

$loggerFactory = Kount_Log_Factory_LogFactory::getLoggerFactory();
$logger = $loggerFactory->getLogger('ExampleClient Factory');

//Example log messages
$logger->debug("Hello world");
$logger->info("Hello world");
$logger->warn("Hello world");
$logger->error("Hello world");
$logger->fatal("Hello world",
    new Exception("Detail message for the exception"));
