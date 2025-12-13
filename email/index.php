<?php
header("Content-Type: application/json; charset=UTF-8");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// VALIDATOR
require "validator/IpseityHermesEmailValidator.php"; 

// EXCEPTION
require "exception/IpseityHermesEmailException.php";

// CONFIGURATION 
require 'configuration/IpseityHermesEmailConfiguration.php';

// RP/TRANSFER
require 'transfer/IpseityHermesEmailResponseTransfer.php';

// RESPONSE
require 'response/IpseityHermesEmailResponse.php';

// SERVICE
require 'service/IpseityHermesEmailService.php';

// CONTROLLER
require 'controller/IpseityHermesEmailController.php';

$parametros = $_GET;

// echo json_encode($parametros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
// exit();

// TESTE | GET
// ?nome=Kauan%20Gomes&whatsapp=5574981295067&email=cauanpereira544%40gmail.com&mensagem=Mensagem%20extensa%20explicando%20um%20objetivo%20comercial&orcamento=3000

if (empty($parametros)) {

    $infoAPI = [
        "api_name" => "ipseity-hermes-api",
        "module_name" => "email",
        "version" => "1.0.8",
        "description" => "API responsável por receber dados de formulários e enviar para o setor administrativo.",
        "author" => "Kauan Gomes",
        "email_destination" => "",
        "objective" => "Receber informações dos campos do formulário (nome, whatsApp, e-mail, mensagem e outros adicionais), validar os dados, gerar hash de envio e enviar e-mails para o administrativo e para o respectivo emissor",
    ];

    echo json_encode($infoAPI, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit();
    
} else {
    $controller = new IpseityHermesEmailController();
    $controller->obterEmail($parametros);
}