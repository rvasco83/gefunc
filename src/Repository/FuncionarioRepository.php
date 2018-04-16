<?php

namespace App\Repository;

use App\Entity\Funcionario;
use App\Entity\Secretaria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\expr;

/**
 * @method Funcionario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Funcionario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Funcionario[]    findAll()
 * @method Funcionario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FuncionarioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Funcionario::class);
    }

//    /**
//     * @return Funcionario[] Returns an array of Funcionario objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Funcionario
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function salarioTotal()
    {
        $q = $this->createQueryBuilder("f")
            ->select('s.nome, SUM(f.salario_liquido) as total')
            ->join("App\Entity\Secretaria", 's', Join::WITH, 'f.Secretaria = s.id')
            ->where('f.status = :status ')
            ->groupBy("s.nome")
            ->setParameter(':status', 'A')
            ->getQuery();

        return $q->getResult();
    }

    public function getFuncionarioAtivoPorData($dataInicio, $dataFim, $status)
    {
        $q = $this->createQueryBuilder("f");
        $campo = 'f.data_exoneracao';
            if($status == 'A'){
                $campo = 'f.data_admissao';
            }
            $q->where(
                $q->expr()->between($campo, ':data1', ':data2')
            );

            $q->setParameter('data1', $dataInicio->format('Y-m-d'));
            $q->setParameter('data2', $dataFim->format('Y-m-d'));


        return $q->getQuery()->getResult();
    }
}
