<?php

namespace App\Http\Controllers;

use App\Models\Baby;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all babies for the dropdown
        $babies = Baby::all();

        // Fetch stats
        $activeBabies = Baby::count();
        $reportsGenerated = Report::count();
        // Due check-ups based on upcoming appointments within 7 days
        $dueCheckups = Baby::whereHas('appointments', function ($query) {
            $query->where('date', '<=', Carbon::today()->addDays(7))
                  ->where('patient_type', 'baby');
        })->count();
        // Vaccinations due based on babies table vaccine fields
        $vaccinationsDue = Baby::where('bcg_vaccine', 0)
            ->orWhere('opv0_vaccine', 0)
            ->orWhere('hepb_vaccine', 0)
            ->count();

        // Fetch recent reports from the reports table
        $recentReports = Report::orderBy('generated_at', 'desc')
            ->take(3)
            ->get();

        // Default baby for preview
        $selectedBabyId = $request->input('baby_id', $babies->first()->id ?? null);
        $selectedBaby = $selectedBabyId ? Baby::find($selectedBabyId) : null;

        // Fetch the latest report for the selected baby (based on baby_name in file_path)
        $latestReport = $selectedBaby ? Report::whereRaw("JSON_EXTRACT(file_path, '$.baby_name') = ?", [$selectedBaby->name])
            ->orderBy('generated_at', 'desc')
            ->first() : null;

        // Prepare report data for preview (from baby or latest report's file_path)
        $reportData = [
            'weight' => $latestReport && isset($latestReport->file_path['weight']) ? $latestReport->file_path['weight'] : ($selectedBaby->current_weight ?? 'N/A'),
            'height' => $latestReport && isset($latestReport->file_path['height']) ? $latestReport->file_path['height'] : ($selectedBaby->current_height ?? 'N/A'),
            'head_circumference' => $latestReport && isset($latestReport->file_path['head_circumference']) ? $latestReport->file_path['head_circumference'] : ($selectedBaby->head_circumference ?? 'N/A'),
            'feeding_data' => $latestReport && isset($latestReport->file_path['feeding_data']) ? $latestReport->file_path['feeding_data'] : ($selectedBaby->additional_notes ?? 'No feeding data recorded'),
            'milestones' => $latestReport && isset($latestReport->file_path['milestones']) ? $latestReport->file_path['milestones'] : (json_decode($selectedBaby->additional_notes, true)['milestones'] ?? []),
            'notes' => $latestReport && isset($latestReport->file_path['notes']) ? $latestReport->file_path['notes'] : ($selectedBaby->additional_notes ?? 'No notes available'),
            'latest_appointment' => $selectedBaby && $selectedBaby->latest_appointment ? Carbon::parse($selectedBaby->latest_appointment->date)->format('M d, Y') : 'N/A',
        ];

        // Prepare growth chart data
        $growthData = [
            'labels' => ['Birth', '1 Month', '2 Months', '3 Months', '4 Months', '5 Months'],
            'weight' => $selectedBaby ? [$selectedBaby->birth_weight, $selectedBaby->current_weight ?? 3.2, 4.1, 4.9, 5.5, 5.9, 6.2] : [],
            'height' => $selectedBaby ? [$selectedBaby->birth_height ?? 50, $selectedBaby->current_height ?? 50, 53, 55, 57, 59, 61] : [],
        ];

        return view('midwife.report', compact(
            'babies',
            'activeBabies',
            'reportsGenerated',
            'dueCheckups',
            'vaccinationsDue',
            'recentReports',
            'selectedBaby',
            'reportData',
            'growthData'
        ));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'baby_id' => 'required|exists:babies,id',
            'report_type' => 'required|string',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'data' => 'array',
        ]);

        $baby = Baby::findOrFail($request->baby_id);
        $reportData = [
            'baby_name' => $baby->name,
            'weight' => $baby->current_weight,
            'height' => $baby->current_height,
            'head_circumference' => $baby->head_circumference,
            'feeding_data' => $baby->additional_notes,
            'milestones' => json_decode($baby->additional_notes, true)['milestones'] ?? [],
            'notes' => $baby->additional_notes,
            'latest_appointment' => $baby->latest_appointment ? Carbon::parse($baby->latest_appointment->date)->format('M d, Y') : 'N/A',
        ];

        // Save report to the reports table
        Report::create([
            'report_type' => $request->report_type,
            'file_path' => $reportData,
            'start_date' => $request->date_from,
            'end_date' => $request->date_to,
            'generated_at' => Carbon::now(),
        ]);

        return redirect()->route('reports.index')->with('success', 'Report generated successfully.');
    }
}
