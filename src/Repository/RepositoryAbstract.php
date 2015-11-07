<?php
namespace Del\Repository;

use Del\Entity\HydratableInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class RepositoryAbstract
{
    /** @var \Doctrine\DBAL\Connection */
    protected $connection;

    /** @var string $table */
    protected $table;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getDBALConnection()
    {
        return $this->connection;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $query = $this->getDBALConnection()->prepare($sql);
        $query->bindValue('id', $id);
        $query->execute();

        $row = $query->fetch();
        return $row;
    }

    public function delete($id)
    {
        $this->getDBALConnection()->delete($this->table, ['id' => $id]);
    }

    /**
     * @param QueryBuilder $query
     * @param $limit
     * @param $offset
     * @return QueryBuilder
     */
    protected function setLimitAndOffset(QueryBuilder &$query, $limit, $offset = 0)
    {
        if ($offset > -1) {
            $query->setFirstResult($offset);
        }
        if ($limit) {
            $query->setMaxResults($limit);
        }
        return $query;
    }

    /**
     * @param $entity
     * @return HydratableInterface
     */
    public function save(HydratableInterface $entity)
    {
        $array = $entity->toArray();
        if (empty($array['id'])) {
            $this->getDBALConnection()->insert($this->table, $array);
            $id = $this->getDBALConnection()->lastInsertId();
            $entity->setId($id);
        } else {
            $this->connection->update($this->table, $array, ['id' => $array['id']]);
        }
        return $entity;
    }
}