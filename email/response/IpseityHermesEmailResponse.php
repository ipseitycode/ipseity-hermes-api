<?php
class IpseityHermesEmailResponse { 
    private $validator;
    private $mensagem = [];

    public function __construct() {

        $this->validator = new IpseityHermesEmailValidator();
    } 

    public function receberDadosGenericos($parametros, $responseTransfer) 
    {
        $resultado = null;

        try {

            $nome     = $parametros['nome'];
            $whatsapp = $parametros['whatsapp'];
            $email    = $parametros['email'];
            $mensagem = $parametros['mensagem'];
            $orcamento = $parametros['orcamento'];

            $responseTransfer->setNome($nome);
            $responseTransfer->setWhatsapp($whatsapp);
            $responseTransfer->setEmail($email);
            $responseTransfer->setMensagem($mensagem);
            $responseTransfer->setOrcamento($orcamento);

            $resultado = $responseTransfer;

        } catch(Exception $e) {
            $this->mensagem[] = IpseityHermesEmailException::incorreto(__METHOD__, 'response.incorreto=' . $e->getMessage());
        }
            
        return $resultado;
    }

    public function visualizarMensagem()
    {
        foreach ($this->mensagem as $key => $msg) {
            print_r($msg);
        }

        return $this->mensagem;
    }

}
?>