<?php

class IpseityHermesEmailConfiguration
{

    private $siteURL = 'SEU_SITE_URL';
    private $siteDominio = 'SEU_SITE_DOMINIO';
    private $receptor = 'EMAIL_RECEPTOR';
    private $remetenteEmail = 'REMETENTE_EMAIL';
    private $remetenteNome  = 'REMETENTE_NOME';
    private $assuntoPadrao = 'SOLICITACAO DE ORCAMENTO';
    private $ticket;
    private $assuntoTicket; 

    public function __construct()
    {
        // ASSUNTO TICKET
        $this->assuntoTicket = 'SOLICITACAO DE ORCAMENTO | TICKET ' . $this->getTicket();
    }

    public function getReceptor()
    {
        return $this->receptor;
    }

    public function getRemetente()
    {
        return [
            'email' => $this->remetenteEmail,
            'nome'  => $this->remetenteNome
        ];
    }

    public function getAssuntoPadrao()
    {
        return $this->assuntoPadrao;
    }

    public function getTicket()
    {
        $ticket = str_pad(
            random_int(0, 99999999),
            8,
            '0',
            STR_PAD_LEFT
        );

        return $this->ticket = $ticket;
    }

    public function getAssuntoTicket()
    {
        return $this->assuntoTicket;
    }

    public function configurarModeloEmail($responseTransfer)
    {
        $nomeUsuario      = $responseTransfer->getNome();
        $whatsappUsuario  = $responseTransfer->getWhatsapp();
        $emailUsuario     = $responseTransfer->getEmail();
        $mensagemUsuario  = $responseTransfer->getMensagem();
        $orcamentoUsuario = $responseTransfer->getOrcamento();

        $dataEnvio = date('d/m/Y');
        $horaEnvio = date('H:i:s');

        return "
            <div style='
                width: 100%;
                background-color: #f8f8f8;
                font-family: Arial, sans-serif;
                font-size: 15px;
                line-height: 1.6;
                color: #333;
            '>

                <div style='
                    max-width: 600px;
                    margin: auto;
                    background: #ffffff;
                    padding: 20px;
                    border-radius: 12px;
                    border: 1px solid #e5e5e5;
                    box-shadow: none;
                '>

                    <h2 style='color: #111; margin-bottom: 10px;'>Nova mensagem recebida</h2>
                    <p>Você recebeu uma nova mensagem de orçamento.</p>

                    <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>

                    <p>
                        <strong>Nome:</strong> {$nomeUsuario} <br>
                        <strong>WhatsApp:</strong> {$whatsappUsuario} <br>
                        <strong>E-mail:</strong> {$emailUsuario} <br>
                        <strong>Mensagem:</strong> {$mensagemUsuario} <br>
                        <strong>Orçamento:</strong> R$ {$orcamentoUsuario} <br>
                        <strong>Numero do Ticket:</strong> {$this->ticket} <br>
                        <strong>Solicitado em:</strong> {$dataEnvio} | {$horaEnvio}
                    </p>

                    <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>

                    <p style='font-size: 13px; color: #777;'>
                        <strong>
                            Atenciosamente,<br>
                            Equipe SUA_EQUIPE<br>
                            Sistema: SEU_SISTEMA</strong><br>
                            <a href='{$this->siteURL}' target='_blank' style='color:#0d6efd; text-decoration:none;'>
                                {$this->siteDominio}
                            </a>
                    </p>

                </div>

            </div>
        ";

    }

    public function configurarModeloEmailTicket($responseTransfer)
    {
        $nomeUsuario      = $responseTransfer->getNome();
        $nomeUsuario      = ucfirst($nomeUsuario);
        $whatsappUsuario  = $responseTransfer->getWhatsapp();
        $emailUsuario     = $responseTransfer->getEmail();
        $mensagemUsuario  = $responseTransfer->getMensagem();
        $orcamentoUsuario = $responseTransfer->getOrcamento();

        $dataEnvio = date('d/m/Y');
        $horaEnvio = date('H:i:s');

        return "
            <div style='
                width: 100%;
                background-color: #f8f8f8;
                font-family: Arial, sans-serif;
                font-size: 15px;
                line-height: 1.6;
                color: #333;
            '>

                <div style='
                    max-width: 600px;
                    margin: auto;
                    background: #ffffff;
                    padding: 20px;
                    border-radius: 12px;
                    border: 1px solid #e5e5e5;
                    box-shadow: none;
                '>

                    <h2 style='color: #111; margin-bottom: 10px;'>Olá, {$nomeUsuario} 👋</h2>
                    <p>Recebemos sua solicitação de orçamento com sucesso.</p>

                    <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>

                    <p>
                        <strong>Nome:</strong> {$nomeUsuario} <br>
                        <strong>WhatsApp:</strong> {$whatsappUsuario} <br>
                        <strong>E-mail:</strong> {$emailUsuario} <br>
                        <strong>Mensagem:</strong> {$mensagemUsuario} <br>
                        <strong>Orçamento:</strong> R$ {$orcamentoUsuario} <br>
                        <strong>Numero do Ticket:</strong> {$this->ticket} <br>
                        <strong>Solicitado em:</strong> {$dataEnvio} | {$horaEnvio}
                    </p>

                    <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>

                    <p>Nossa equipe irá analisar sua solicitação e retornar em breve. <br>
                    Obrigado!
                    </p>

                    <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>

                    <p style='font-size: 13px; color: #777;'>
                        <strong>
                            Atenciosamente,<br>
                            Equipe SUA_EQUIPE</strong><br>
                            <a href='{$this->siteURL}' target='_blank' style='color:#0d6efd; text-decoration:none;'>
                                {$this->siteDominio}
                            </a>
                    </p>

                </div>

            </div>
        ";

    }

}
