<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//VALIDATOR 
require '../validator/IpseityHermesEmailValidator.php';

//EXCEPTION
require '../exception/IpseityHermesEmailException.php';

//SERVICE
require '../service/IpseityHermesEmailService.php';

//CONTROLLER
require 'IpseityHermesEmailController.php'; 