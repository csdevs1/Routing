<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $nombre
 * @property string $direccion
 * @property string $rut
 * @property string $lat
 * @property string $lng
 * @property string $created_at
 * @property Vehiculo[] $vehiculos
 * @property Usuario[] $usuarios
 * @property Cliente[] $clientes
 */
class Oficinas extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['nombre', 'direccion', 'rut', 'lat', 'lng', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehiculos()
    {
        return $this->hasMany('App\Vehiculo', 'id_oficina');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usuarios()
    {
        return $this->hasMany('App\Usuario', 'id_oficina');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientes()
    {
        return $this->hasMany('App\Cliente', 'id_oficina');
    }
}
