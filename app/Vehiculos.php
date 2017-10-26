<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_oficina
 * @property integer $id_grupo
 * @property string $nombre
 * @property string $patente
 * @property float $outerwidth
 * @property float $outerlength
 * @property float $outerdepth
 * @property float $emptyweight
 * @property float $innerwidth
 * @property float $innerlength
 * @property float $innerdepth
 * @property float $maxweight
 * @property string $created_at
 * @property string $updated_at
 * @property Oficina $oficina
 * @property Grupovehiculo $grupovehiculo
 * @property Documento[] $documentos
 */
class Vehiculos extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_oficina', 'id_grupo', 'nombre', 'patente', 'outerwidth', 'outerlength', 'outerdepth', 'emptyweight', 'innerwidth', 'innerlength', 'innerdepth', 'maxweight', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function oficina()
    {
        return $this->belongsTo('App\Oficina', 'id_oficina');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grupovehiculo()
    {
        return $this->belongsTo('App\Grupovehiculo', 'id_grupo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentos()
    {
        return $this->hasMany('App\Documentos', 'id_vehiculo');
    }
}
