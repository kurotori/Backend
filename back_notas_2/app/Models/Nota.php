<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasUuids; //Facilita el uso de UUIDs en el modelo

    protected $table = 'notas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'titulo',
        'texto'
    ];

    //BACKEND: la característica BelongsTo permite identificar el registro
    //          de la *otra entidad* al que un elemento de esta
}
