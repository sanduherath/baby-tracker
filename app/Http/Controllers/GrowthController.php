<?php
namespace App\Http\Controllers;

use App\Models\ClinicRecord;
use App\Models\Baby;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GrowthController extends Controller
{
    public function show($baby_id)
    {
        if (!is_numeric($baby_id) || $baby_id <= 0) {
            abort(404, 'Invalid baby ID');
        }

        $baby = Baby::findOrFail($baby_id);
        $baby_name = $baby->name;
        $age = Carbon::parse($baby->date_of_birth)->diffInMonths(Carbon::now());

        $records = ClinicRecord::where('patient_id', $baby_id)
            ->orderBy('created_at', 'asc')
            ->get([
                'weight',
                'height',
                'head_circumference',
                'created_at',
                'nutrition',
                'vaccination_name',
                'midwife_accommodations'
            ]);

        Log::info('Raw Clinic Records for baby_id ' . $baby_id, ['records' => $records->toArray()]);

        $labels = $records->map(fn($record) => Carbon::parse($record->created_at)->format('M Y'))->toArray();
        $weights = $records->map(fn($record) => $record->weight ? floatval($record->weight) : null)->toArray();
        $heights = $records->map(fn($record) => $record->height ? floatval($record->height) : null)->toArray();
        $head_circumferences = $records->map(fn($record) => $record->head_circumference ? floatval($record->head_circumference) : null)->toArray();
        $bmis = $records->map(function ($record) {
            $bmi = $record->weight && $record->height
                ? round($record->weight / (($record->height / 100) ** 2), 1)
                : null;
            Log::info('BMI Calculation', [
                'weight' => $record->weight,
                'height' => $record->height,
                'bmi' => $bmi
            ]);
            return $bmi;
        })->toArray();

        $latest_record = $records->last() ?: (object) ['nutrition' => null, 'vaccination_name' => null, 'midwife_accommodations' => null];
        $latest_date = $latest_record->created_at ? Carbon::parse($latest_record->created_at)->format('F d, Y') : 'N/A';
        $latest_weight = $latest_record->weight ? floatval($latest_record->weight) : null;
        $latest_height = $latest_record->height ? floatval($latest_record->height) : null;
        $latest_head_circumference = $latest_record->head_circumference ? floatval($latest_record->head_circumference) : null;
        $latest_bmi = $latest_weight && $latest_height
            ? round($latest_weight / (($latest_height / 100) ** 2), 1)
            : 'N/A';

        $weight_percentile = $latest_weight ? $this->estimatePercentile($latest_weight, 'weight') : 'N/A';
        $height_percentile = $latest_height ? $this->estimatePercentile($latest_height, 'height') : 'N/A';
        $head_percentile = $latest_head_circumference ? $this->estimatePercentile($latest_head_circumference, 'head') : 'N/A';
        $bmi_percentile = $latest_bmi !== 'N/A' ? $this->estimatePercentile($latest_bmi, 'bmi') : 'N/A';

        Log::info('Processed Data for baby_id ' . $baby_id, [
            'labels' => $labels,
            'weights' => $weights,
            'heights' => $heights,
            'head_circumferences' => $head_circumferences,
            'bmis' => $bmis,
            'latest_bmi' => $latest_bmi
        ]);

        return view('baby.growth', compact(
            'baby_id', 'baby_name', 'age', 'labels', 'weights', 'heights', 'head_circumferences', 'bmis',
            'latest_weight', 'latest_height', 'latest_head_circumference', 'latest_bmi', 'latest_date',
            'weight_percentile', 'height_percentile', 'head_percentile', 'bmi_percentile', 'latest_record'
        ));
    }

    private function estimatePercentile($value, $type)
    {
        $standards = [
            'weight' => ['50th' => 7.0, 'threshold' => 0.1],
            'height' => ['50th' => 66.0, 'threshold' => 0.2],
            'head' => ['50th' => 43.0, 'threshold' => 0.3],
            'bmi' => ['50th' => 16.8, 'threshold' => 0.2],
        ];
        $standard = $standards[$type]['50th'];
        $threshold = $standards[$type]['threshold'];
        return ($value >= $standard - $threshold && $value <= $standard + $threshold) ? '50th' : ($value < $standard - $threshold ? '45th' : '60th');
    }
}
