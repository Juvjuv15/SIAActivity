<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use App\Traits\UuidModel;


class User extends Authenticatable 
{
    // use UuidModel;
    use Notifiable;
    // use HasRoles;

    protected $primarykey='id';
    public $incrementing=true;
    public $timestamps = true;
    // protected $casts = [
    //     'created_at' => 'datetime:Y-m-d',
    // ];
    // protected $dateFormat = 'U';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','contact','secondarycontact', 'address', 'email', 'password','userType','remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get user sold lots.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function soldLots()
    {
        return $this->hasMany(SellerLessorTransaction::class);
    }

    /**
     * Get user intended lots.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function intendedLots()
    {
        return $this->hasMany(BuyerLesseeTransaction::class);
    }

    public function profilepic()
    {
        return $this->hasOne('App\Profile','user_fk','id');
    }


}
