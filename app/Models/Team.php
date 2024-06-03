<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'is_active'
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
	 * Get users
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function users()
	{
		return $this->belongsToMany(User::class, 'user_has_team', 'team_id', 'user_id')
        ->withPivot(['presence','created_at', 'updated_at']);
	}

	/**
	 * Get log team
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function log()
	{
        return DB::table('log_team')
            ->join('team', function ($join) {
                $join->on('log_team.team1_id', '=', 'team.id')
                    ->orWhere('log_team.team2_id', '=', 'team.id');
            })
            ->select('log_team.*', DB::raw("CASE
                WHEN log_team.team1_id = team.id THEN 'mandante'
                WHEN log_team.team2_id = team.id THEN 'visitante'
                ELSE NULL
            END AS team_role"))
            ->get();
	}
}