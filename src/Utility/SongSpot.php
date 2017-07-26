<?php 
namespace App\Utility;

class SongSpot
{
    public $songId;
    public $songName;
    public $albumId;
    public $albumName;
    public $artistId;
    public $artistName;
    
    public function __construct($songId, $songName, $albumId, $albumName, $artistId, $artistName)
    {
       $this->songId  = $songId;
       $this->songName = $songName;
       $this->albumId = $albumId;
       $this->albumName = $albumName;
       $this->artistId  = $artistId;
       $this->artistName = $artistName;
    }
}