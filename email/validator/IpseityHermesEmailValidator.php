<?php
class IpseityHermesEmailValidator
{

    public function validarConsultaSQL($consulta = null): bool
    {
        $resultado = isset($consulta)
            && mb_strlen($consulta) > 100
            ? true
            : false;
        return $resultado;
    }

    public function validarArtigoCodigo($codigo)
    {
        return mb_strlen($codigo) == 6
            && is_numeric(($codigo))
            && ($codigo) > 0
            ? $codigo
            : null;
    } 
 
    public function validarClasseMetodo($classe, $metodo)
    {
        if (is_object($classe) && method_exists($classe, $metodo)) {
            return true;
        } else {
            return false;
        }
    }

    public function validarObjeto($objeto)
    {
        if (is_object($objeto)) {
            return true;
        } else {
            return false;
        }
    }

    public function validarString($string)
    {
        return is_string($string) && !empty($string);
    }

    public function validarArray($array)
    {
        return is_array($array) && !empty($array);
    }

    public function validarArrayObjeto($array)
    {
        $resultado = null;
        if (is_array($array) && !empty($array)) {
            $contar = 0;
            foreach ($array as $key => $value) {

                if (is_object($value)) {
                    $resultado = $array;
                }
                
                if ($contar > 0) {
                    break;
                }

                $contar++;
            }
        }
        return $resultado;
    }

    public function conversorSlug($slug)
    {
        $slug = is_string($slug)
            && mb_strlen(trim($slug)) > 3
            && mb_strlen(trim($slug)) <= 300
            ? trim($slug)
            : null;

        if ($slug) {

            $slug = preg_replace('/[_-]+/', '-', $slug);
            $slug = strtolower($slug);
        }

        return $slug;
    }

    public function validarId($id)
    {
        return is_numeric($id)
            && $id > 0
            && $id <= 100000000000 
            ? $id
            : null;
    }

    public function validarHash($hash)
    {
        return is_string($hash) &&
            !empty($hash) &&
            strlen($hash) <= 255 &&
            preg_match('/^(?:[\da-f]{32}|[\da-f]{40}|[\da-f]{64}|[\da-f]{128}|\$2[aby]?\$.{56}|\$argon2(id|i)\$[^\s]{10,})$/i', $hash)
            ? $hash : null;
    }

    function validarSlug($slug)
    {
        return preg_match('/^[a-z0-9_-]+$/', $slug);
    }

    public function validarArquivoMidia($midia)
    {
        return is_string($midia)
            && !empty(trim($midia))
            && strlen($midia) <= 255
            && preg_match('/\.(jpg|jpeg|png|gif|mp4|avi|mov|mkv)$/i', $midia)
            ? $midia
            : null;
    }

    public function validarPreco($preco)
    {
        return is_numeric($preco) && $preco >= 0;
    }

    public function validarNumero($numero)
    {
        return is_numeric($numero) && $numero >= 0
        ? (int)$numero : null;
    }

    public function validarDecimal($numero)
    {
        return is_numeric($numero) && $numero >= 0.0 && $numero <= 5.0
            ? (float)$numero : null;
    }

    public function validarAtivo($ativo)
    {
        return is_numeric($ativo) && ($ativo == 0 || $ativo == 1)
        ? (int)$ativo : null;
    }

}