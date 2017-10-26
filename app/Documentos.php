<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_cliente
 * @property integer $id_vehiculo
 * @property string $created_at
 * @property string $codigo
 * @property string $fecha_despacho
 * @property string $fecha_pactada
 * @property boolean $prioridad
 * @property string $updated_at
 * @property Cliente $cliente
 * @property Vehiculo $vehiculo
 * @property Documentositem[] $documentositems
 */
class Documentos extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_cliente', 'id_vehiculo', 'created_at', 'codigo', 'fecha_despacho', 'fecha_pactada', 'prioridad', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'id_cliente');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehiculo()
    {
        return $this->belongsTo('App\Vehiculo', 'id_vehiculo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentositems()
    {
        return $this->hasMany('App\Documentositem', 'id_documento');
    }
}
