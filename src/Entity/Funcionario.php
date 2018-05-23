<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FuncionarioRepository")
 */
class Funcionario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Secretaria")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Secretaria;
    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $nome;
    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $logadouro;
    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $numero;
    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $bairro;
    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $cidade;
    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $estado;
    /**
     * @var string
     * @ORM\Column(type="string", length=13, unique=true)
     * @Assert\NotBlank()
     */
    private $identidade;
    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\Image(mimeTypes={"image/*"},
     *      mimeTypesMessage="Arquivo inválido"
     *      )
     */
    private $imagem_documento;
    /**
     * @var string
     * @ORM\Column(type="string", length=1)
     * @Assert\NotBlank()
     * @Assert\Choice(choices={"E", "C"})
     */
    private $cargo;
    /**
     * @var string
     * @ORM\Column(type="string", length=1)
     * @Assert\Choice(choices={"A", "E"})
     */
    private $status;
    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $data_admissao;
    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $data_exoneracao;
    /**
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\NotBlank()
     * @Assert\Range(min="0", max="10000000")
     */
    private $salario_base;
    /**
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Assert\Range(min="0", max="10000000")
     */
    private $gratificacao;
    /**
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\NotBlank()
     * @Assert\Range(min="0", max="10000000")
     */
    private $desconto;
    /**
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\Range(min="0", max="10000000")
     */
    private $salario_liquido;
    public function calculaLiquido(){
        $liquido = ($this->getSalarioBase() + $this->getGratificacao()) - $this->getDesconto();
        $this->setSalarioLiquido($liquido);
    }
    public function getId()
    {
        return $this->id;
    }
    public function getSecretaria()
    {
        return $this->Secretaria;
    }
    public function setSecretaria($Secretaria)
    {
        $this->Secretaria = $Secretaria;
        return $this;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }
    public function getLogadouro()
    {
        return $this->logadouro;
    }
    public function setLogadouro($logadouro)
    {
        $this->logadouro = $logadouro;
        return $this;
    }
    public function getNumero()
    {
        return $this->numero;
    }
    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }
    public function getBairro()
    {
        return $this->bairro;
    }
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
        return $this;
    }
    public function getCidade()
    {
        return $this->cidade;
    }
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
        return $this;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }
    public function getIdentidade()
    {
        return $this->identidade;
    }
    public function setIdentidade($identidade)
    {
        $this->identidade = $identidade;
        return $this;
    }
    public function getImagemDocumento()
    {
        return $this->imagem_documento;
    }
    public function setImagemDocumento($imagem_documento): self
    {
        $this->imagem_documento = $imagem_documento;
        return $this;
    }
    public function getCargo()
    {
        return $this->cargo;
    }
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
        return $this;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    public function getDataAdmissao()
    {
        return $this->data_admissao;
    }
    public function setDataAdmissao($data_admissao)
    {
        $this->data_admissao = $data_admissao;
        return $this;
    }
    public function getDataExoneracao()
    {
        return $this->data_exoneracao;
    }
    public function setDataExoneracao($data_exoneracao)
    {
        $this->data_exoneracao = $data_exoneracao;
        return $this;
    }
    public function getSalarioBase()
    {
        return $this->salario_base;
    }
    public function setSalarioBase($salario_base)
    {
        $this->salario_base = $salario_base;
        return $this;
    }
    public function getGratificacao()
    {
        return $this->gratificacao;
    }
    public function setGratificacao($gratificacao)
    {
        $this->gratificacao = $gratificacao;
        return $this;
    }
    public function getDesconto()
    {
        return $this->desconto;
    }
    public function setDesconto($desconto)
    {
        $this->desconto = $desconto;
        return $this;
    }
    public function getSalarioLiquido()
    {
        return $this->salario_liquido;
    }
    public function setSalarioLiquido($salario_liquido)
    {
        $this->salario_liquido = $salario_liquido;
        return $this;
    }
}
