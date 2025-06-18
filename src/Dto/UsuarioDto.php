<?php 

namespace App\Dto;

class UsuarioDto
{
    private string $nome;
    private string $email;
    private string $telefone;

    //Função do Nome
    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }
    //Função do Email
    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }
    //Função do Telefone
    public function getNTelefone() {
        return $this->telefone;
    }
    public function setTelefone($telefone) {
        $this->telefone = $telefone;
        return $this;
    }
}