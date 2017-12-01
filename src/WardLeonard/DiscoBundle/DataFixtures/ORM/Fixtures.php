<?php

namespace WardLeonard\DiscoBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use WardLeonard\DiscoBundle\Entity\Disk;
use WardLeonard\DiscoBundle\Entity\Lyric;
use WardLeonard\DiscoBundle\Entity\Title;


class Fixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $disk = new Disk();
        $disk->setTitle('Western');
        $disk->setDateSortie(new \DateTime('2017'));
        $manager->persist($disk);
        $manager->flush();

        $disk = $manager->getRepository('WardLeonardDiscoBundle:Disk')->findOneByTitle('Western');

        $title = new Title();
        $title->setTitle("Vouloir c'est pouvoir");
        $title->setDisk($disk);
        $manager->persist($title);
        $manager->flush();

        $title = $manager->getRepository('WardLeonardDiscoBundle:Title')->findOneByTitle("Vouloir c'est pouvoir");

        $lyric = new Lyric();
        $lyric->setTitle($title);
        $lyric->setContent('
                Tout ceux qui me disent que vouloir c\'est pouvoir<br>
                me font bien rigoler avec leurs histoires<br>
                il n\'y a que dans les contes qu\'on transforme les crapauds<br>
                il n\'y a que dans la bible qu\'on peut marcher sur l\'eau<br><br>

                Reprenez les rêves dont vous êtes les apôtres<br>
                nous ne sommes pas égaux allez les vendre à d\'autres<br><br>

                Le point sur le i la barre sur le t, il n\'y a pas d\'égalité<br>
                Le point sur le i la barre sur le t, il n\'y a pas d\'égalité<br><br>

                Quand tu nais en Afrique de parents sidaïques<br>
                Ta chance de survie nest pas plus grosse qu\'un confetti<br><br>

                Quand tu nais à Sarcelles au milieu des poubelles<br>
                ta chance d\'être président avoisine le néant<br>
                Donne moi le pourcentage de fils d\'ouvriers<br>
                qui sont devenus ministres, qui ont fait HEC<br><br>

                Le point sur le i la barre sur le t, il n\'y a pas dégalité<br>
                Le point sur le i la barre sur le t, il n\'y a pas dégalité<br><br>

                Vouloir c\'est pouvoir donne une bonne conscience<br>
                à tous ceux qui cherchent une reconnaissance<br>
                Vouloir c\'est pouvoir c\'est tirer un trait<br>
                sur toutes les chances qu\'hier on te donnait<br><br>

                Mieux vaut être né dans les beaux quartiers<br> 
                aller à l\'école dans les classes protégées<br>
                pour les autres c\'est sur il faudra du courage<br>
                vouloir cest pouvoir éviter le naufrage<br><br>

                Limiter la casse, parer au plus pressé<br>
                et viser les places qu\'on veut bien te laisser.<br><br>

                Le point sur le i la barre sur le t, il n\'y a pas dégalité<br>
                Le point sur le i la barre sur le t, il n\'y a pas dégalité<br>
                Le point sur le i la barre sur le t, il n\'y a pas dégalité<br>
                Le point sur le i la barre sur le t, il n\'y a pas dégalité<br>
            ');

        $manager->persist($lyric);
        $manager->flush();

    }
}