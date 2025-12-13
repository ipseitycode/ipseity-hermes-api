<?php

class IpseityHermesEmailController
{
    private $validator;
    private $service;
    private $mensagem = [];
  
    public function __construct() 
    {   
        $this->validator = new IpseityHermesEmailValidator();
        $this->service = new IpseityHermesEmailService();
    }
 
    public function obterEmail($parametros)
    {
        try { 

            if ($this->validator->validarClasseMetodo($this->service, 'executarEmail')) 
            { 
                $resultado = $this->service->prepararEmail($parametros);

            } else {
                $this->mensagem[] = IpseityHermesEmailException::inexistente(__METHOD__, 'executarEmail.inexistente');
            }

        } catch (Exception $e) {
            $this->mensagem[] = IpseityHermesEmailException::incorreto(__METHOD__, 'controller.incorreto=' . $e->getMessage());
        }

        echo json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit();
    }

    public function visualizarMensagem(bool $exibir = true)
    {
        if ($exibir) {
            foreach ($this->mensagem as $msg) {
                echo $msg . PHP_EOL;
            }
        }

        return $this->mensagem;
    }

}