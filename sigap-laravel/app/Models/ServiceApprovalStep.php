<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceApprovalStep extends Model
{
    protected $fillable = ['service_type_id', 'urutan', 'nama_tahap', 'role_id'];

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function role()
    {
        return $this->belongsTo(\Spatie\Permission\Models\Role::class, 'role_id');
    }
}
