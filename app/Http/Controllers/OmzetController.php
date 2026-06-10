<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Resources\OmzetResource;
use Illuminate\Http\Request;

class OmzetController extends Controller
{
    public function index(Request $request)
    {
        // Hanya task yang benar-benar selesai yang dihitung
        $completedTasks = Task::where('status', 'COMPLETED');

        // Filter opsional by rentang tanggal — berguna untuk laporan bulanan/tahunan
        // Contoh: ?from=2026-01-01&to=2026-06-30
        if ($request->filled('from')) {
            $completedTasks->whereDate('updated_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $completedTasks->whereDate('updated_at', '<=', $request->to);
        }

        $totalTasks  = (clone $completedTasks)->count();
        $omzet       = (clone $completedTasks)->sum('total_estimated_fee');
        $labaBersih  = $omzet * 0.20;

        // Breakdown per komponen biaya — berguna untuk analisis
        $breakdown = [
            'total_base_fee'         => (clone $completedTasks)->sum('base_fee'),
            'total_job_category_fee' => (clone $completedTasks)->sum('job_category_fee'),
            'total_distance_fee'     => (clone $completedTasks)->sum('distance_fee'),
            'total_tips_fee'         => (clone $completedTasks)->sum('tips_fee'),
            'total_discount'         => (clone $completedTasks)->sum('discount'),
        ];

        $data = [
            'total_completed_tasks' => $totalTasks,
            'omzet'                 => (int) $omzet,
            'laba_bersih'           => (int) $labaBersih,
            'breakdown'             => $breakdown,
            'filter'                => [
                'from' => $request->from ?? null,
                'to'   => $request->to   ?? null,
            ],
        ];

        return response()->json([
            'success' => true,
            'data'    => new OmzetResource((object) $data),
        ]);
    }

    // Breakdown per bulan dalam satu tahun — untuk grafik di dashboard admin
    public function monthly(Request $request)
    {
        $year = $request->input('year', now()->year);

        $monthly = Task::where('status', 'COMPLETED')
            ->whereYear('updated_at', $year)
            ->selectRaw('
                MONTH(updated_at)        AS bulan,
                COUNT(*)                 AS total_tasks,
                SUM(total_estimated_fee) AS omzet,
                SUM(total_estimated_fee) * 0.20 AS laba_bersih
            ')
            ->groupByRaw('MONTH(updated_at)')
            ->orderByRaw('MONTH(updated_at)')
            ->get()
            ->map(function ($row) {
                return [
                    'bulan'       => (int) $row->bulan,
                    'total_tasks' => (int) $row->total_tasks,
                    'omzet'       => (int) $row->omzet,
                    'laba_bersih' => (int) $row->laba_bersih,
                ];
            });

        return response()->json([
            'success' => true,
            'year'    => (int) $year,
            'data'    => $monthly,
        ]);
    }
    // Pendapatan mitra hari ini — under middleware auth:mitra
    public function mitraToday(Request $request)
    {
        $mitra = $request->user(); // guard mitra

        $completedToday = Task::where('status', 'COMPLETED')
            ->where('mitra_id', $mitra->id)
            ->whereDate('updated_at', today())
            ->selectRaw('
                COUNT(*)                          AS total_tasks,
                SUM(total_estimated_fee)          AS omzet_platform,
                SUM(total_estimated_fee) * 0.80   AS pendapatan_mitra
            ')
            ->first();

        return response()->json([
            'success' => true,
            'data'    => [
                'tanggal'          => today()->toDateString(),
                'tugas_diselesaikan' => (int) ($completedToday->total_tasks ?? 0),
                'pendapatan_hari_ini' => (int) ($completedToday->pendapatan_mitra ?? 0),
            ],
        ]);
    }
}