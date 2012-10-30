<?php if (!defined('BASE_PATH')) exit('No direct script access allowed');

/**
 * The base command class that will be extended by other commands
 */
abstract class BaseCommand
{
    abstract public function run();
}
