<?php

namespace App\Livewire\Warga;

use App\Models\ServiceSubmission;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class MySubmissions extends Component
{
    public function render()
    {
        $submissions = ServiceSubmission::with('serviceType')
            ->where('submitted_by', Auth::id())
            ->latest()
            ->get();

        return view('livewire.warga.my-submissions', compact('submissions'));
    }
}
