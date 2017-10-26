<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $description
 * @property string $codigo
 * @property string $tipo
 * @property float $width
 * @property float $length
 * @property float $depth
 * @property float $weight
 * @property string $created_at
 * @property string $updated_at
 * @property Documentositem[] $documentositems
 */
class Productos extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['description', 'codigo', 'tipo', 'width', 'length', 'depth', 'weight', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentositems()
    {
        return $this->hasMany('App\Documentositem', 'id_producto');
    }
}
