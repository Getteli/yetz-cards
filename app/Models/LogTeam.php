<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTeam extends Model
{
    use HasFactory;

    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'log_team';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team1_id',
        'score_team1',
        'team2_id',
        'score_team2'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

	/**
	 * Get principal team
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function principal()
	{
		return $this->belongsTo(Team::class,'team1_id');
	}

	/**
	 * Get visitor team
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function visitor()
	{
		return $this->belongsTo(Team::class,'team2_id');
	}
}