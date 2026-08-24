<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionApproval extends Model
{
    protected $fillable = ['submission_id', 'step_id', 'approver_id', 'status', 'catatan', 'waktu'];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function submission()
    {
        return $this->belongsTo(ServiceSubmission::class, 'submission_id');
    }

    public function step()
    {
        return $this->belongsTo(ServiceApprovalStep::class, 'step_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
