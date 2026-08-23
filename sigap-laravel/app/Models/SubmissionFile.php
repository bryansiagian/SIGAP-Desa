<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionFile extends Model
{
    protected $fillable = ['submission_id', 'field_key', 'original_filename', 'stored_path', 'mime_type', 'size_kb'];

    public function submission()
    {
        return $this->belongsTo(ServiceSubmission::class, 'submission_id');
    }
}
