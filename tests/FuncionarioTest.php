<?php

namespace App\Tests;


use App\Entity\Funcionario;
use PHPUnit\Framework\TestCase;


class FuncionarioTest extends TestCase
{
    public function testSetGetName()
    {
        $funcionario = new Funcionario();
        $this->assertNull($funcionario->getNome());
        $this->assertInstanceOf(Funcionario::class, $funcionario->setNome("Rodrigo"));
        $this->assertEquals("Rodrigo", $funcionario->getNome());
    }

    public function testSetGetSalarioLiquido()
    {
        $funcionario = new Funcionario();
        $this->assertNull($funcionario->getSalarioBase());
        $this->assertNull($funcionario->getGratificacao());
        $this->assertNull($funcionario->getDesconto());
        $this->assertNull($funcionario->getSalarioLiquido());
        $this->assertInstanceOf(Funcionario::class, $funcionario->setSalarioBase(1000));
        $this->assertInstanceOf(Funcionario::class, $funcionario->setGratificacao(1000));
        $this->assertInstanceOf(Funcionario::class, $funcionario->setDesconto(500));
        $funcionario->calculaLiquido();
        $this->assertEquals(1500, $funcionario->getSalarioLiquido());
    }
}