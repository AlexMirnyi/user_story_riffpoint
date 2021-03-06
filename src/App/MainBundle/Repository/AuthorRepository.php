<?php

namespace App\MainBundle\Repository;

use Doctrine\ORM\EntityRepository;
use App\MainBundle\Entity\Author;

/**
 * AuthorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AuthorRepository extends EntityRepository
{
    public function create(){
        return new Author();
    }

    public function save(Author $author){
        $this->getEntityManager()->persist($author);
        $this->getEntityManager()->flush();
    }

    public function getBookList(){

        $qb = $this->createQueryBuilder('q');

        $qb
            ->leftJoin('q.books', 'b');

        return $qb->getQuery()->getResult();
    }
}
