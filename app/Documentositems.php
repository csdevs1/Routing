<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_documento
 * @property integer $id_producto
 * @property integer $cantidad
 * @property string $created_at
 * @property string $updated_at
 * @property Documento $documento
 * @property Producto $producto
 */
class Documentositems extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_documento', 'id_producto', 'cantidad', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function documento()
    {
        return $this->belongsTo('App\Documentos', 'id_documento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto()
    {
        return $this->belongsTo('App\Productos', 'id_producto');
    }
}
