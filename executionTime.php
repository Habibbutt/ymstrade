<?php
register_shutdown_function('shutdown');

function executionTime() {
    $CI = & get_instance();
    $IP = $CI->input->ip_address();
    $controller = $CI->router->fetch_class();
    $action = $CI->router->fetch_method();
    $now = date('Y-m-d H:i:s');
    $time = number_format(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 4);
    return "[$IP] [$now] [{$controller}/{$action}] [{$time} seconds]";
}

function shutdown() {
    ob_start();
    $exeTime = executionTime();
    //outputExecutionTime($exeTime);
    logExecutionTime($exeTime);
}

function outputExecutionTime($log) {
    $output = ob_get_clean();
    $jsonResponse = json_decode($output, TRUE);
    if (!empty($jsonResponse)) {
        $jsonResponse['performance'] = $log;
        echo json_encode($jsonResponse);
    } else {
        echo $output . "<!-- {$log} -->";
    }
}

function logExecutionTime($log) {
    $CI = & get_instance();
    $filename = date('Y-m-d-') . session_id() . '.log';
    write_file($CI->config->item('Performance_Log_Path') . '/' . $filename, $log . PHP_EOL, 'a+');
}
