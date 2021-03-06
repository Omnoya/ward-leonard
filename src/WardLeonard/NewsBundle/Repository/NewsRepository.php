<?php

namespace WardLeonard\NewsBundle\Repository;

/**
 * NewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return array
     */
    public function getNewsByOrderDesc()
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('n')
            ->from('WardLeonardNewsBundle:News', 'n')
            ->orderBy('n.datepublication', 'DESC')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @return array
     */
    public function getNewsByOrderAsc()
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->add('select',  'n')
            ->add('from', 'WardLeonardNewsBundle:News n')
            ->add('orderBy', 'n.datepublication')
            ->getQuery();

        return $query->getResult();
    }


}
