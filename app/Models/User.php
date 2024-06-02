<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        'is_goalkeeper'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'level' => 'integer',
        'is_goalkeeper' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

	/**
	 * Get team
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function teams()
	{
		return $this->belongsToMany(Team::class, 'user_has_team', 'user_id', 'team_id')
        ->withPivot(['presence','created_at', 'updated_at', 'deleted_at']);
	}
}