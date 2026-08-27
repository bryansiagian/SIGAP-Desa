<?php

namespace App\Livewire\Admin;

use App\Models\ServiceSubmission;
use App\Models\ServiceType;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $totalKeseluruhan = ServiceSubmission::count();

        $totalBulanIni = ServiceSubmission::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $perStatus = ServiceSubmission::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $topLayanan = ServiceType::withCount('submissions')
            ->orderByDesc('submissions_count')
            ->take(5)
            ->get();

        $recentSubmissions = ServiceSubmission::with('serviceType', 'submitter')
            ->latest()
            ->take(6)
            ->get();

        return view('livewire.admin.dashboard', [
            'totalKeseluruhan' => $totalKeseluruhan,
            'totalBulanIni' => $totalBulanIni,
            'perStatus' => $perStatus,
            'topLayanan' => $topLayanan,
            'recentSubmissions' => $recentSubmissions,
        ]);
    }
}
