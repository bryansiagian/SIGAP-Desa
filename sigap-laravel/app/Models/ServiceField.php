<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceField extends Model
{
    protected $fillable = ['service_type_id', 'field_key', 'label', 'field_type', 'options', 'validation_rule', 'is_required', 'urutan'];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
    ];

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }
}
