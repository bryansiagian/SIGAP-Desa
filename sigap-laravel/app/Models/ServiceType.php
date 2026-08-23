<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = ['key', 'nama_layanan', 'kategori', 'deskripsi', 'is_builtin', 'status', 'dibuat_oleh'];

    public function fields()
    {
        return $this->hasMany(ServiceField::class)->orderBy('urutan');
    }

    public function approvalSteps()
    {
        return $this->hasMany(ServiceApprovalStep::class)->orderBy('urutan');
    }

    public function submissions()
    {
        return $this->hasMany(ServiceSubmission::class);
    }
}
