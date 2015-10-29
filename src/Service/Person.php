<?php

namespace Del\Service;

use Del\Collection\Person as PersonCollection;
use Del\Entity\Person;
use Del\Repository\Person as PersonRepository;
use Pimple\Container;

class Person
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

   /** 
    * @param array $data
    * @return Person
    */
    public function createFromArray(array $data)
    {
        $person = new Person();
        return $person;
    }

   /**
    * @return PersonRepository
    */
    public function getRepository()
    {
        return $this->container['repository.person'];
    }
}
