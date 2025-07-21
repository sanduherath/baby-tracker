<!DOCTYPE html>
<html>
<head>
    <title>Thriposha Stock Overview Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #2b7c85;
            margin-bottom: 5px;
        }
        .header .subtitle {
            color: #666;
            font-size: 14px;
        }
        .report-info {
            margin-bottom: 20px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #2b7c85;
            color: white;
            padding: 8px;
            text-align: left;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .status {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-processing {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }
        .status-pending {
            background-color: #f8d7da;
            color: #721c24;
        }
        .summary {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #666;
        }
        .section-break {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Thriposha Stock Overview Report</h1>
        <div class="subtitle">Generated on {{ now()->format('M d, Y h:i A') }}</div>
    </div>

    <div class="report-info">
        <p><strong>Report Period:</strong> {{ $startDate->format('M d, Y') }} to {{ $endDate->format('M d, Y') }}</p>
        @if($typeFilter)
        <p><strong>Type Filter:</strong> {{ ucfirst($typeFilter) }} Thriposha</p>
        @endif
    </div>

    <!-- Distribution Section -->
    <div class="section-break">
        <h3>Distributions</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Recipient</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($distributions as $distribution)
                <tr>
                    <td>{{ $distribution->date->format('M d, Y') }}</td>
                    <td>{{ ucfirst($distribution->type) }}</td>
                    <td>{{ $distribution->quantity }} packs</td>
                    <td>{{ $distribution->recipient }}</td>
                    <td>{{ $distribution->notes ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No distributions found for the selected period</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Orders Section -->
    <div class="section-break">
        <h3>Orders</h3>
        <table>
            <thead>
                <tr>
                    <th>Order Date</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Expected Delivery</th>
                    <th>Urgency</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->order_date->format('M d, Y') }}</td>
                    <td>{{ ucfirst($order->type) }}</td>
                    <td>{{ $order->quantity }} packs</td>
                    <td>
                        <span class="status status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>{{ $order->expected_delivery_date ? $order->expected_delivery_date->format('M d, Y') : 'N/A' }}</td>
                    <td>{{ ucfirst($order->urgency) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No orders found for the selected period</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Stock Summary Section -->
    <div class="summary">
        <h3>Stock Summary</h3>
        <p><strong>Current Baby Thriposha Stock:</strong> {{ $babyStock }} packs</p>
        <p><strong>Current Mother Thriposha Stock:</strong> {{ $motherStock }} packs</p>
        <p><strong>Total Current Stock:</strong> {{ $babyStock + $motherStock }} packs</p>
        <p><strong>Total Distributions (Period):</strong> {{ $totalDistributed }} packs</p>
        <p><strong>Total Orders (Period):</strong> {{ $totalOrdered }} packs</p>
        <p><strong>Net Stock Adjustment (Additions - Distributions):</strong> {{ $netStockAdjustment }} packs</p>
    </div>

    <div class="footer">
        <p>Generated by: {{ Auth::user()->name ?? 'System' }}</p>
    </div>
</body>
</html>
