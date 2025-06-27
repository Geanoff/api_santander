<?php 

namespace App\Dto;

class TransacaoDto
{
    private ?string $contaOrigem = null;
    private ?string $contaDestino = null;
    private ?string $valor= null;

    /**
     * Get the value of contaOrigem
     */ 
    public function getContaOrigem()
    {
        return $this->contaOrigem;
    }

    /**
     * Set the value of contaOrigem
     *
     * @return  self
     */ 
    public function setContaOrigem($contaOrigem)
    {
        $this->contaOrigem = $contaOrigem;

        return $this;
    }

    /**
     * Get the value of contaDestino
     */ 
    public function getContaDestino()
    {
        return $this->contaDestino;
    }

    /**
     * Set the value of contaDestino
     *
     * @return  self
     */ 
    public function setContaDestino($contaDestino)
    {
        $this->contaDestino = $contaDestino;

        return $this;
    }

    /**
     * Get the value of valor
     */ 
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set the value of valor
     *
     * @return  self
     */ 
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }
}