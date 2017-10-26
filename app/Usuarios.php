<?php
/*
namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $fillable = ['id_oficina', 'nombre', 'email', 'password', 'created_at'];

    public function oficina()
    {
        return $this->belongsTo('App\Oficina', 'id_oficina');
    }
}
*/

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuarios extends Authenticatable
{
    use Notifiable;
    
    protected $guard = 'usuarios';
    protected $table = 'users';
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}