<?php 
class IpseityHermesEmailResponseTransfer {

    private $nome;
    private $whatsapp;
    private $email;
    private $mensagem;
    private $orcamento;

    public function __construct() 
    {
        
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getWhatsapp()
    {
        return $this->whatsapp;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getMensagem()
    {
        return $this->mensagem;
    }

    public function getOrcamento()
    {
        return $this->orcamento;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function setWhatsapp($whatsapp)
    {
        $this->whatsapp = $whatsapp;
        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
        return $this;
    }

    public function setOrcamento($orcamento)
    {
        $this->orcamento = $orcamento;
        return $this;
    }

}