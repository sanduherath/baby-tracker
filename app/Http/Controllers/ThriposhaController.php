<?php

namespace App\Http\Controllers;

use App\Models\ThriposhaDistribution;
use App\Models\ThriposhaOrder;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class ThriposhaController extends Controller
{
    public function index()
    {
        $distributions = ThriposhaDistribution::where('transaction_type', 'distribution')
            ->latest()
            ->take(5)
            ->get();

        $patients = Patient::all();

        $babyStock = $this->calculateStock('baby');
        $motherStock = $this->calculateStock('mother');

        $orders = ThriposhaOrder::latest()->take(5)->get();

        return view('midwife.nutrition', compact('distributions', 'patients', 'babyStock', 'motherStock', 'orders'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|before_or_equal:today',
            'type' => 'required|in:baby,mother',
            'quantity' => 'required|integer|min:1',
            'recipient_id' => 'nullable|exists:patients,id',
            'recipient' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ThriposhaDistribution::create([
            'date' => $request->date,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'transaction_type' => 'distribution',
            'recipient' => $request->recipient,
            'recipient_id' => $request->recipient_id,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Distribution recorded successfully.');
    }

    public function addStock(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stockThriposhaType' => 'required|in:baby,mother',
            'stockQuantity' => 'required|integer|min:1',
            'stockNotes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $latestRecord = ThriposhaDistribution::latest()->first();
        $babyStock = $latestRecord ? $latestRecord->baby_thriposha_quantity : 0;
        $motherStock = $latestRecord ? $latestRecord->mother_thriposha_quantity : 0;

        if ($request->stockThriposhaType === 'baby') {
            $babyStock += $request->stockQuantity;
        } else {
            $motherStock += $request->stockQuantity;
        }

        $newRecord = ThriposhaDistribution::create([
            'date' => now(),
            'type' => $request->stockThriposhaType,
            'quantity' => $request->stockQuantity,
            'transaction_type' => 'addition',
            'recipient' => 'Stock Addition',
            'recipient_id' => null,
            'notes' => $request->stockNotes,
            'baby_thriposha_quantity' => $babyStock,
            'mother_thriposha_quantity' => $motherStock,
        ]);

        return response()->json([
            'success' => 'Stock added successfully.',
            'babyStock' => $babyStock,
            'motherStock' => $motherStock,
            'lastReceived' => [
                'type' => $request->stockThriposhaType,
                'date' => $newRecord->date->format('M d, Y'),
                'quantity' => $newRecord->quantity,
            ],
        ]);
    }

    public function storeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'thriposhaType' => 'required|in:baby,mother',
            'orderQuantity' => 'required|integer|min:10',
            'orderUrgency' => 'required|in:normal,urgent,emergency',
            'orderNotes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $orderDate = now();
        $expectedDeliveryDate = match ($request->orderUrgency) {
            'normal' => $orderDate->copy()->addWeeks(2),
            'urgent' => $orderDate->copy()->addWeek(),
            'emergency' => $orderDate->copy()->addDays(3),
            default => $orderDate->copy()->addWeeks(2),
        };

        $order = ThriposhaOrder::create([
            'order_date' => $orderDate,
            'type' => $request->thriposhaType,
            'quantity' => $request->orderQuantity,
            'urgency' => $request->orderUrgency,
            'notes' => $request->orderNotes,
            'status' => 'pending',
            'expected_delivery_date' => $expectedDeliveryDate,
        ]);

        return response()->json([
            'success' => 'Order placed successfully.',
            'order' => [
                'order_date' => $order->order_date->format('M d, Y'),
                'type' => ucfirst($order->type),
                'quantity' => $order->quantity,
                'status' => $order->status,
                'expected_delivery_date' => $order->expected_delivery_date->format('M d, Y'),
            ],
        ]);
    }

    public function generateReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reportType' => 'required|in:distribution,order,stock,recipient,coverage',
            'startDate' => 'required|date|before_or_equal:today',
            'endDate' => 'required|date|after_or_equal:startDate|before_or_equal:today',
            'recipientId' => 'nullable|exists:patients,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $startDate = Carbon::parse($request->startDate);
        $endDate = Carbon::parse($request->endDate);
        $reportType = $request->reportType;
        $recipientId = $request->recipientId;
        $typeFilter = null;
        $statusFilter = null;

        if ($reportType === 'recipient') {
            if (!$recipientId) {
                return response()->json(['errors' => ['recipientId' => 'Recipient is required for this report type.']], 422);
            }

            $distributions = ThriposhaDistribution::where('transaction_type', 'distribution')
                ->where('recipient_id', $recipientId)
                ->whereBetween('date', [$startDate, $endDate])
                ->get();

            $recipient = Patient::find($recipientId);
            $typeFilter = null;
        } else {
            $distributionsQuery = ThriposhaDistribution::where('transaction_type', 'distribution')
                ->whereBetween('date', [$startDate, $endDate]);

            $ordersQuery = ThriposhaOrder::whereBetween('order_date', [$startDate, $endDate]);

            if ($reportType === 'distribution') {
                $typeFilter = $request->typeFilter ?? null;
                if ($typeFilter) {
                    $distributionsQuery->where('type', $typeFilter);
                }
            } elseif ($reportType === 'order') {
                $typeFilter = $request->typeFilter ?? null;
                $statusFilter = $request->statusFilter ?? null;
                if ($typeFilter) {
                    $ordersQuery->where('type', $typeFilter);
                }
                if ($statusFilter) {
                    $ordersQuery->where('status', $statusFilter);
                }
            } elseif ($reportType === 'stock') {
                $typeFilter = $request->typeFilter ?? null;
                if ($typeFilter) {
                    $distributionsQuery->where('type', $typeFilter);
                    $ordersQuery->where('type', $typeFilter);
                }
            }

            $distributions = $distributionsQuery->get();
            $orders = $ordersQuery->get();
        }

        if ($reportType === 'distribution' || $reportType === 'recipient') {
            $babyTotal = $distributions->where('type', 'baby')->sum('quantity');
            $motherTotal = $distributions->where('type', 'mother')->sum('quantity');

            return view('midwife.reports.distribution', compact(
                'distributions',
                'startDate',
                'endDate',
                'typeFilter',
                'babyTotal',
                'motherTotal'
            ));
        } elseif ($reportType === 'order') {
            $totalQuantity = $orders->sum('quantity');
            $statusCounts = $orders->groupBy('status')->map->count();

            return view('midwife.reports.order', compact(
                'orders',
                'startDate',
                'endDate',
                'typeFilter',
                'statusFilter',
                'totalQuantity',
                'statusCounts'
            ));
        } elseif ($reportType === 'stock') {
            $babyStock = $this->calculateStock('baby');
            $motherStock = $this->calculateStock('mother');
            $totalDistributed = $distributions->sum('quantity');
            $totalOrdered = $orders->sum('quantity');

            $additions = ThriposhaDistribution::where('transaction_type', 'addition')
                ->whereBetween('date', [$startDate, $endDate]);
            if ($typeFilter) {
                $additions->where('type', $typeFilter);
            }
            $totalAdditions = $additions->sum('quantity');
            $netStockAdjustment = $totalAdditions - $totalDistributed;

            return view('midwife.reports.stock', compact(
                'distributions',
                'orders',
                'startDate',
                'endDate',
                'typeFilter',
                'babyStock',
                'motherStock',
                'totalDistributed',
                'totalOrdered',
                'netStockAdjustment'
            ));
        }

        return response()->json(['error' => 'Invalid report type'], 400);
    }

    protected function calculateStock($type)
    {
        $additions = ThriposhaDistribution::where('type', $type)
            ->where('transaction_type', 'addition')
            ->sum('quantity');

        $distributions = ThriposhaDistribution::where('type', $type)
            ->where('transaction_type', 'distribution')
            ->sum('quantity');

        return max(0, $additions - $distributions);
    }
}
