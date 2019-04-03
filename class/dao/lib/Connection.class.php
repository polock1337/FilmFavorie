<?php
namespace FilmFavoris;
use PDO;

class Connection 
{
    private $pdolocal = 0;
    public function __construct()
    {
        $conStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;",
                          "127.0.0.1",
                          '5432',
                          'favorite_movie');
        $user = 'postgres';
        $pass = 'Yoyo1234';
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($conStr, $user, $pass, $options);
            $this->pdolocal = $pdo;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    public function getPDO()
    {
       return $this->pdolocal;
    }
}
