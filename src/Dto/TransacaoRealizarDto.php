<?php 

namespace App\Dto;

class TransacaoRealizarDto
{
    private ?string $idUsuarioOrigem = null;
    private ?string $idUsuarioDestino = null;
    private ?string $valor = null;

    /**
     * Get the value of idUsuarioOrigem
     */ 
    public function getIdUsuarioOrigem()
    {
        return $this->idUsuarioOrigem;
    }

    /**
     * Set the value of idUsuarioOrigem
     *
     * @return  self
     */ 
    public function setIdUsuarioOrigem($idUsuarioOrigem)
    {
        $this->idUsuarioOrigem = $idUsuarioOrigem;

        return $this;
    }

    /**
     * Get the value of cdUsuarioDestino
     */ 
    public function getIdUsuarioDestino()
    {
        return $this->idUsuarioDestino;
    }

    /**
     * Set the value of cdUsuarioDestino
     *
     * @return  self
     */ 
    public function setIdUsuarioDestino($cdUsuarioDestino)
    {
        $this->idUsuarioDestino = $cdUsuarioDestino;

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