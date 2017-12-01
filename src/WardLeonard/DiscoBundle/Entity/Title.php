<?php

namespace WardLeonard\DiscoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Title
 *
 * @ORM\Table(name="title")
 * @ORM\Entity(repositoryClass="WardLeonard\DiscoBundle\Repository\TitleRepository")
 */
class Title
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="WardLeonard\DiscoBundle\Entity\Disk")
     * @ORM\JoinColumn(name="disk_id", referencedColumnName="id", nullable=true)
     */
    private $disk;

    /**
     * @var
     *
     * @ORM\Column(name="title",type="string",length=200)
     */
    private $title;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set morceau
     *
     * @param string $disk
     *
     * @return Title
     */
    public function setDisk($disk)
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * Get morceau
     *
     * @return string
     */
    public function getDisk()
    {
        return $this->disk;
    }

    /**
     * Set morceautitle
     *
     * @param string $title
     *
     * @return Title
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get morceautitle
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
