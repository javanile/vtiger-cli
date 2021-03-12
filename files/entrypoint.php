<?php
/**
 *
 */

require_once __VENDOR_DIR__.'/autoload.php';

/**
 *
 */
$_VTIGER_CLI_CONTAINER = null;

/**
 * @return mixed|null
 */
function vtiger_cli_container()
{
    global $_VTIGER_CLI_CONTAINER;

    if ($_VTIGER_CLI_CONTAINER === null) {
        $_VTIGER_CLI_CONTAINER = include_once __CONTAINER_FILE__;
    }

    return $_VTIGER_CLI_CONTAINER;
}

/**
 *
 */
function vtiger_cli_entrypoint_entity_method()
{
    $backtrace = debug_backtrace();
    $module = $backtrace[1]['args'][0]->moduleName;
    $method = $backtrace[1]['args'][1];

    $class = explode('::', $method);
    $container = vtiger_cli_container();

    if ($container->has($class[0])) {
        $instance = $container->get($class[0]);
        call_user_func_array([$instance, $class[1]], func_get_args());
    }
}
