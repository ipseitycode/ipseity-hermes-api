<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class IpseityHermesEmailService
{
    private $validator;
    private $response;
    private $configuration;
    private $responseTransfer;
    private $mensagem = [];

    public function __construct() 
    {
        $this->validator = new IpseityHermesEmailValidator();
        $this->configuration = new IpseityHermesEmailConfiguration();
        $this->response = new IpseityHermesEmailResponse();
        $this->responseTransfer = new IpseityHermesEmailResponseTransfer();
    }

    public function prepararEmail($parametros) 
    {   
        $resultado = [];
        
        try {
         
            if ($this->validator->validarClasseMetodo($this->response, 'receberDadosGenericos')) 
            {
                $responseTransfer = $this->response->receberDadosGenericos($parametros, $this->responseTransfer);

                if ($this->validator->validarClasseMetodo($this->configuration, 'configurarModeloEmail') &&
                    $this->validator->validarClasseMetodo($this->configuration, 'configurarModeloEmailTicket')) 
                { 
                    $modeloEmail = $this->configuration->configurarModeloEmail($responseTransfer);
                    $modeloEmailTicket = $this->configuration->configurarModeloEmailTicket($responseTransfer);

                    $resultado = $this->executarEmail($modeloEmail, $modeloEmailTicket);

                } else {
                    $this->mensagem[] = IpseityHermesEmailException::inexistente(__METHOD__, 'configurarModeloEmail.inexistente');
                    $this->mensagem[] = IpseityHermesEmailException::inexistente(__METHOD__, 'configurarModeloEmailTicket.inexistente');
                }

            } else {
                $this->mensagem[] = IpseityHermesEmailException::inexistente(__METHOD__, 'receberEmail.inexistente');
            }

        } catch (Exception $e) {
            $this->mensagem[] = IpseityHermesEmailException::incorreto(__METHOD__, 'service.incorreto=' . $e->getMessage());
        } 

        return $resultado;
    }

    private function executarEmail($modeloEmail, $modeloEmailTicket) 
    {   
        $resultado = [];
        
        try {

            // PHPMailer
            require_once __DIR__ . '/../vendor/phpmailer/src/PHPMailer.php';
            require_once __DIR__ . '/../vendor/phpmailer/src/SMTP.php';
            require_once __DIR__ . '/../vendor/phpmailer/src/Exception.php';

            $mail = new PHPMailer(true);

            // CONFIG SMTP
            $mail->isSMTP();
            $mail->Host       = 'SEU_HOST';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'SEU_USERNAME';
            $mail->Password   = 'SEU_PASSWORD'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 0; // SUA_PORTA

            // REMETENTE E DESTINATARIO
            $remetente  = $this->configuration->getRemetente();
            $receptor   = $this->configuration->getReceptor();
            $assunto = $this->configuration->getAssuntoTicket();

            $mail->setFrom($remetente['email'], $remetente['nome']);
            $mail->addAddress($receptor);

            $dataAtual = date('d/m/Y');

            // CONTEUDO
            $mail->isHTML(true);
            $mail->Subject = $assunto . ' | ' . $dataAtual;
            $mail->Body    = $modeloEmail;

            // ENVIO
            if ($mail->send()) {

                // ENVIO DO TICKET AO USUÁRIO
                $mail->clearAddresses();
                $mail->clearAttachments();

                $emailUsuario = $this->responseTransfer->getEmail();
                $nomeUsuario = $this->responseTransfer->getNome();
                $assuntoTicket = $this->configuration->getAssuntoTicket();

                $mail->addAddress($emailUsuario, $nomeUsuario);
                $mail->Subject = $assuntoTicket;

                $mail->Body = $modeloEmailTicket;

                $mail->send();

                // RESPOSTA FINAL DA API | JSON
                $resultado = [
                    'status'  => 'success',
                    'code'    => 200,
                    'message' => 'E-mail enviado com sucesso.',
                    'details' => [
                        'timestamp' => date('Y-m-d H:i:s'),
                        'mailer_info' => 'PHPMailer executado com êxito. Nenhuma mensagem de erro gerada.',
                    ]
                ];

            } else {

                    $resultado = [
                        'status'  => 'error',
                        'code'    => 500, 
                        'message' => 'Falha ao enviar o e-mail.',
                        'details' => [
                            'timestamp' => date('Y-m-d H:i:s'),
                            'error_description' => 'O servidor de e-mail não aceitou a mensagem ou houve erro de configuração.',
                            'mailer_error'      => $mail->ErrorInfo,
                        ]
                    ];
                }

        } catch (\Exception $e) {
            $this->mensagem[] = IpseityHermesEmailException::incorreto(__METHOD__,'service.incorreto=' . $e->getMessage());
        } 

        return $resultado;
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