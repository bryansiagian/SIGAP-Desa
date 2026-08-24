<?php

namespace App\Livewire\Warga;

use App\Models\ServiceType;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ServiceIndex extends Component
{
    public function render()
    {
        $serviceTypes = ServiceType::where('status', 'aktif')->orderBy('nama_layanan')->get();

        return view('livewire.warga.service-index', compact('serviceTypes'));
    }
}
