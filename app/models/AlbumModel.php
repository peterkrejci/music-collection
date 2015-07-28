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
    public function add(ArrayAccess $albumData)
    {
        $album = new Album();
        $album->setArtist($albumData['artist']);
        $album->setAlbumName($albumData['albumName']);
        $album->setYear($albumData['year']);

        $this->em->persist($album);
        $this->em->flush();
    }

    /**
     * @param Album $album
     * @param ArrayAccess $albumData
     */
    public function edit(Album $album, ArrayAccess $albumData)
    {
        $album->setArtist($albumData['artist']);
        $album->setAlbumName($albumData['albumName']);
        $album->setYear($albumData['year']);

        $this->em->persist($album);
        $this->em->flush();
    }

    /**
     * @param $albumId
     */
    public function delete($albumId)
    {
        /**
         * @var Album $album
         */
        $album = $this->albumDao->find($albumId);
        $album->delete();

        $this->em->persist($album);
        $this->em->flush();
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $qb = $this->em->createQueryBuilder();
        $query = $qb->select('a')
            ->from(Album::class, 'a')
            ->where('a.deletedAt IS NULL');

        return $query->getQuery()->getResult();
    }

    /**
     * @param $albumId
     * @return Album
     */
    public function get($albumId)
    {
        return $this->albumDao->find($albumId);
    }
}