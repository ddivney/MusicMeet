<?php

namespace App\Utility;
use App\Utility\SongSpot;
use App\Utility\ArtistSpot;

class SpotOperator
{
     public static function getFollowedArtists($api)
     {
        $artistsObj = $api->getUserFollowedArtists();
        $limit = $artistsObj->artists->limit;
        $numArt = $artistsObj->artists->total;
        $options = [];
        $iterations = ceil($numArt / $limit);
        $artists = array();
        while ($iterations > 0)
        {
            for($i = 0; $i < count ($artistsObj->artists->items); $i++ )
             {
                $artistName = $artistsObj->artists->items[$i] -> name;
                $artistId = $artistsObj->artists->items[$i] -> id; 
               foreach($artistsObj->artists->items[$i] -> genres as $key => $value)
               {
                   $genre = $artistsObj->artists->items[$i] -> genres[$key]; 
                   $artists[] = new ArtistSpot($artistId, $artistName, $genre);
               }
             
             }
             $options['limit'] = $limit;
             $options['after'] = $artistsObj -> artists -> limit;
             $artistsObj = $api -> getUserFollowedArtists($options);
             $iterations --;
        } 
        return $artists;
     }
     
    
     
     public static function getAddedTracks($api)
     {
        $tracksObj = $api -> getMySavedTracks();
        $limit = $tracksObj -> limit;
        $numTracks = $tracksObj -> total;
        $options = [];
        $iterations = ceil($numTracks / $limit);
        $offset = 0;
        $songs = array();
        
        while ($iterations > 0)
        {
             for($i = 0; $i < count ($tracksObj->items); $i++ )
            {
                  $songName = $tracksObj -> items[$i] -> track -> name;
                  $songId = $tracksObj -> items[$i] -> track -> id;
                  $albumName = $tracksObj -> items[$i] -> track -> album -> name;
                  $albumId = $tracksObj -> items[$i] -> track -> album -> id;
                  $artistName = $tracksObj -> items[$i] -> track -> artists[0] -> name;
                  $artistId = $tracksObj -> items[$i] -> track -> artists[0] -> id;
                  $songs[] = new SongSpot($songId, $songName, $albumId, $albumName, $artistId, $artistName);
            }
             $offset += $limit;
             $options['limit'] = $limit;
             $options['offset'] = $offset;
             $tracksObj = $api -> getMySavedTracks($options);
             $iterations --;
        }
        return $songs;
     }
    
    public static function getPlaylistsTracks($api, $id)
    {
        $playlistsObj = $api -> getMyPlaylists();
        $limit = $playlistsObj -> limit;
        $numPlaylists = $playlistsObj -> total;
        $options = [];
        $iterations = ceil($numPlaylists / $limit);
        $offset = 0;
        $songs = array();
        
         while ($iterations > 0)
        {
             for($i = 0; $i < count ($playlistsObj->items); $i++ )
            {
                $idPlaylist =  $playlistsObj -> items[$i] -> id;
                $uri = $playlistsObj -> items[$i] -> uri;
                if(strpos($uri, $id) !== false)
                {
                    $extracted = self::extractTracks($api, $id, $idPlaylist);
                    $songs = array_merge($songs, $extracted);
                }
            }
             $offset += $limit;
             $options['limit'] = $limit;
             $options['offset'] = $offset;
             $playlistsObj = $api -> getMyPlaylists($options);
             $iterations --;
        }
        return $songs;
    }
    
    private static function extractTracks($api, $idUser, $idPlaylist)
    {
        
        $playlistTracks = $api -> getUserPlaylistTracks($idUser, $idPlaylist, []);
        $limit = $playlistTracks -> limit;
        $numTracks = $playlistTracks -> total;
        $options = [];
        $iterations = ceil($numTracks / $limit);
        $offset = 0;
       
        $songs = array();
         
       while ($iterations > 0)
       {
           for($i = 0; $i < count ($playlistTracks->items); $i++ )
           {
               $songName = $playlistTracks -> items[$i] -> track -> name;
               $songId   = $playlistTracks -> items[$i] -> track -> id ;
               $albumName = $playlistTracks -> items[$i] -> track -> album -> name;
               $albumId = $playlistTracks -> items[$i] -> track -> album -> id ;
               $artistName = $playlistTracks -> items[$i] -> track -> artists[0] -> name;
               $artistId = $playlistTracks -> items[$i] -> track -> artists[0] -> id;
               $songs[] = new SongSpot($songId, $songName, $albumId, $albumName, $artistId, $artistName);
           }
            $offset += $limit;
           // $options['limit'] = $limit;
            $options['offset'] = $offset;
            $playlistsObj = $api -> getMyPlaylists($options);
            $iterations --;
       }
       return $songs;
    }
    
    public static function getRecentlyPlayedTracks($api)
    {
        $options = [];
        $options['limit'] = 20;
        $recentTracks = $api -> getMyRecentTracks($options);
        $songs = array();
     
        for($i = 0; $i < count ($recentTracks->items); $i++ )
        {
               $songName = $recentTracks -> items[$i] -> track -> name;
               $songId = $recentTracks -> items[$i] -> track -> id;
               $albumName =  $recentTracks -> items[$i] -> track -> album -> name;
               $albumId =  $recentTracks -> items[$i] -> track -> album -> id;
               $artistName =  $recentTracks -> items[$i] -> track -> artists[0] -> name;
               $artistId = $recentTracks -> items[$i] -> track -> artists[0] -> id;
               $songs[] = new SongSpot($songId, $songName, $albumId, $albumName, $artistId, $artistName);
        }
        return $songs;
     
    }
    
    public static function getUserId($api)
    {
        $myInfo = $api -> me();
        return $myInfo -> id;
    }
}