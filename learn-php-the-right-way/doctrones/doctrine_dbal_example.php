<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\Column;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$connectionParams = [
    'dbname'   => $_ENV['DB_DATABASE'],
    'user'     => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'host'     => $_ENV['DB_HOST'],
    'driver'   => 'pdo_mysql',
];

try {
    /**
     * $stmt->executeQuery for SELECT
     * <br />
     * $stmt->executeStatement() for INSERT UPDATE DELETE
     */
    $conn = DriverManager::getConnection($connectionParams);
    // $stmt   = $conn->prepare('SELECT * FROM emails WHERE id=?');
    // $result = $stmt->executeQuery([1]);
    // $stmt = $conn->prepare('SELECT * FROM emails WHERE id=:id');
    // $result = $stmt->executeQuery(['id' => 1]);
    // $stmt = $conn->prepare('SELECT id,subject FROM emails WHERE created_at between :from AND :to');
    // $stmt->bindValue(':from', '2024-01-12 00:00:00');
    // $stmt->bindValue(':to', '2024-01-12 23:59:59');
    // $timezone = new DateTimeZone('Asia/Shanghai');
    // $template = 'Y-m-d H:i:s';
    // $from     = DateTime::createFromFormat($template, '2024-01-12 00:00:00');
    // $to       = DateTime::createFromFormat($template, '2024-01-12 23:59:59');
    // $stmt->bindValue(':from', $from, 'datetime');
    // $stmt->bindValue(':to', $to, 'datetime');
    // $result = $stmt->executeQuery();
    // $arr    = $result->fetchAllAssociative();
    // var_dump($arr);
    // $stmt->executeStatement();

    //    $ids = [1, 2, 3];
    //    $result = $conn->exiwcuteQuery(
    //        'SELECT id, created_at from emails WHERE id IN (?)',
    //        [$ids],
    //        [ArrayParameterType::INTEGER]
    //    );
    //    $arr    = $result->fetchAllAssociative();
    //    var_dump($arr);

    //    $result = $conn->fetchAllAssociative(
    //        'SELECT id, created_at from emails WHERE id IN (?)',
    //        [$ids],
    //        [ArrayParameterType::INTEGER]
    //    );
    //    var_dump($result);

    // $conn->beginTransaction();
    // $conn->commit();
    // $conn->rollBack();
    // $conn->transactional(function () { }); // auto commit() or rollback() at the end

    //    $builder = $conn->createQueryBuilder();
    //    $emails  = $builder
    //        ->select('id', 'created_at')
    //        ->from('emails')
    //        ->where('id>?')
    //        ->setParameter(0, 16, ParameterType::INTEGER)
    //        // ->getSQL();
    //        ->fetchAllAssociative();
    //    var_dump($emails);
    $schema = $conn->createSchemaManager();
    // var_dump($schema->listTableNames());
    var_dump(
        array_map(
            fn(Column $column) => $column->getName(),
            $schema->listTableColumns('emails')
        )
    );
} catch (\Doctrine\DBAL\Exception $e) {
    echo $e;
} catch (Throwable $e) {
}
