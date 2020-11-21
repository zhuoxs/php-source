<?php
use GatewayWorker\BusinessWorker;


$business = new BusinessWorker();
$business->name = 'BusinessWorker';

$business->registerAddress  = '127.0.0.1:1234';
$business->eventHandler     = 'MyEvent';






