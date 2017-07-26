<?php 
namespace App\Utility;

class ArtistSpot
{
   
    public $artistId;
    public $artistName;
    public $genreId;
    
    public function __construct( $artistId, $artistName, $genreId)
    {
       $this->artistId  = $artistId;
       $this->artistName = $artistName;
       $this->genreId = $genreId;
    }
}