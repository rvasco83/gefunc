<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Entity\Usuario;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */

class Version20180509194531 extends AbstractMigration implements ContainerAwareInterface
{
    private $container;
    private $encoder;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->encoder = $container->get('security.password_encoder');
    }
    private function getDoctrine()
    {
        return $this->container->get('doctrine');
    }
    public function up(Schema $schema)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $admin = new Usuario();
        $admin
            ->setMatricula('999999')
            ->setEmail('admin@email.com')
            ->setUsername('admin')
            ->setNome('Administrador')
            ->setRoles('ROLE_ADMIN');
        $password = $this->encoder->encodePassword($admin, 'admin123');
        $admin->setPassword($password);
        $entityManager->persist($admin);
        $entityManager->flush();
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
