<?php 
namespace App\Utility;

class Match
{
   
    public $user = null;
    public $score;
    
    public function __construct($user, $score)
    {
       $this->user = $user;
       $this->score  = $score;
    }
    
    public static function cmp($a, $b)
    {
        return ($a -> score < $b -> score);
    }

}