<?php

namespace App\Models;

use App\Models\Entities\Album;
use ArrayAccess;
use Kdyby\Doctrine\EntityDao;
use Kdyby\Doctrine\EntityManager;
use Nette;

class AlbumModel extends Nette\Object
{
    /**
     * @var EntityDao
     */
    private $albumDao;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->albumDao = $em->getRepository(Album::class);
        $this->em = $em;
    }

    /**
     * @param ArrayAccess $albumData
     */
    public function addAlbum(ArrayAccess $albumData)
    {
        $album = new Album();
        $album->setArtist($albumData['artist']);
        $album->setAlbumName($albumData['albumName']);
        $album->setYear($albumData['year']);

        $this->em->persist($album);
        $this->em->flush();
    }

    public function editAlbum($albumId, array $albumData)
    {

    }

    public function deleteAlbum($albumId)
    {

    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->albumDao->findAll();
    }
}