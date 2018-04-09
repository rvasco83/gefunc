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
     * @ORM\Column(type="string", length=10, unique=true)
     * @Assert\NotBlank()
     */
    private $identidade;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\File(mimeTypes={"image/png", "image/jpg", "image/jpeg"})
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

    public function getSecretaria(): ?Secretaria
    {
        return $this->Secretaria;
    }

    public function setSecretaria(?Secretaria $Secretaria): self
    {
        $this->Secretaria = $Secretaria;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getLogadouro(): ?string
    {
        return $this->logadouro;
    }

    public function setLogadouro(string $logadouro): self
    {
        $this->logadouro = $logadouro;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getBairro(): ?string
    {
        return $this->bairro;
    }

    public function setBairro(string $bairro): self
    {
        $this->bairro = $bairro;

        return $this;
    }

    public function getCidade(): ?string
    {
        return $this->cidade;
    }

    public function setCidade(string $cidade): self
    {
        $this->cidade = $cidade;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getIdentidade(): ?string
    {
        return $this->identidade;
    }

    public function setIdentidade(string $identidade): self
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

    public function getCargo(): ?string
    {
        return $this->cargo;
    }

    public function setCargo(?string $cargo): self
    {
        $this->cargo = $cargo;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDataAdmissao(): ?\DateTime
    {
        return $this->data_admissao;
    }

    public function setDataAdmissao(\DateTime $data_admissao): self
    {
        $this->data_admissao = $data_admissao;

        return $this;
    }

    public function getDataExoneracao(): ?\DateTime
    {
        return $this->data_exoneracao;
    }

    public function setDataExoneracao(?\DateTime $data_exoneracao): self
    {
        $this->data_exoneracao = $data_exoneracao;

        return $this;
    }

    public function getSalarioBase(): ?float
    {
        return $this->salario_base;
    }

    public function setSalarioBase(float $salario_base): self
    {
        $this->salario_base = $salario_base;

        return $this;
    }

    public function getGratificacao()
    {
        return $this->gratificacao;
    }

    public function setGratificacao($gratificacao): self
    {
        $this->gratificacao = $gratificacao;

        return $this;
    }

    public function getDesconto(): ?float
    {
        return $this->desconto;
    }

    public function setDesconto(float $desconto): self
    {
        $this->desconto = $desconto;

        return $this;
    }

    public function getSalarioLiquido(): ?float
    {
        return $this->salario_liquido;
    }

    public function setSalarioLiquido(float $salario_liquido): self
    {
        $this->salario_liquido = $salario_liquido;

        return $this;
    }
}
