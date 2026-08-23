<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceSubmission extends Model
{
    protected $fillable = ['service_type_id', 'submitted_by', 'data', 'fields_snapshot', 'current_step', 'status'];

    protected $casts = [
        'data' => 'array',
        'fields_snapshot' => 'array',
    ];

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function approvals()
    {
        return $this->hasMany(SubmissionApproval::class, 'submission_id');
    }

    public function files()
    {
        return $this->hasMany(SubmissionFile::class, 'submission_id');
    }
}
