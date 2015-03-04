<?php

namespace App\MainBundle\Repository;

use Doctrine\ORM\EntityRepository;
use App\MainBundle\Entity\Genre;

/**
 * GenreRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GenreRepository extends EntityRepository
{
    public function create(){
        return new Genre();
    }

    public function save(Genre $genre){
        $this->getEntityManager()->persist($genre);
        $this->getEntityManager()->flush();
    }

    public function selectDistinctGenres(){
        $qb = $this->createQueryBuilder('q')
            ->orderBy('q.type', 'ASC')
            ->groupBy('q.type');

        return $qb;
    }
}