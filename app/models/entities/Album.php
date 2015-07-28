<?php

namespace App\Models\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;

/**
 * Class Album
 * @package App\Models\Entities
 * @ORM\Entity
 */
class Album extends BaseEntity
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $albumId;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $artist;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $albumName;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $year;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="albums")
     **/
    protected $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getAlbumId()
    {
        return $this->albumId;
    }

    /**
     * @param integer $albumId
     */
    public function setAlbumId($albumId)
    {
        $this->albumId = $albumId;
    }

    /**
     * @return string
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param string $artist
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    /**
     * @return string
     */
    public function getAlbumName()
    {
        return $this->albumName;
    }

    /**
     * @param string $albumName
     */
    public function setAlbumName($albumName)
    {
        $this->albumName = $albumName;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param DateTime $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    public function delete()
    {
        $this->setDeletedAt(new DateTime());
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return bool
     */
    public function hasUsers()
    {
        return count($this->users);
    }
}