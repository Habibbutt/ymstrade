<?php

/*
 * Specfically for the load balancer
 * Checks if the system is ready to take the load, i.e. cache and all critical stuff is done
 */

http_response_code(504); // default status code
if (extension_loaded('apcu') & 'y' == apcu_fetch('systemUp')) {// send 200 i.e OK only if apcu is loaded and the systemUp is y
    http_response_code(200);
}