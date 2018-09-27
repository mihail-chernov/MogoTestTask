<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'games';

    protected $primaryKey = 'game_id';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function team1()
    {
        return $this->hasOne('App\Team','team_id', 'team1_id');
    }

    public function team2()
    {
        return $this->hasOne('App\Team', 'team_id', 'team2_id');
    }


}
