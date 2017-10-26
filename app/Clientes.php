<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_oficina
 * @property string $nombre
 * @property string $direccion
 * @property string $lat
 * @property string $lng
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property string $created_at
 * @property integer $codigo
 * @property string $label
 * @property Oficina $oficina
 * @property Documento[] $documentos
 */
class Clientes extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_oficina', 'nombre', 'direccion', 'lat', 'lng', 'hora_inicio', 'hora_fin', 'created_at', 'codigo', 'label'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function oficina()
    {
        return $this->belongsTo('App\Oficina', 'id_oficina');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentos()
    {
        return $this->hasMany('App\Documentos', 'id_cliente');
    }
}
