<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 5;
            padding: 5;
            box-sizing: border-box;
            font-family: DejaVu Sans, Arial, sans-serif;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            line-height: 1;
            color: #000000;
            background: #ffffff;
            padding: 0;
            margin: 0;
            font-size: 12px;
        }

        .invoice-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 10px;
            background: #ffffff;
        }

        /* Header styles */
        .header {
            margin-bottom: 10px;
            border-bottom: 3px solid #333;
            padding-bottom: 5px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 800;
            color: #2563eb;
            margin-bottom: 5px;
        }

        .header .invoice-number {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }

        .company-info {
            text-align: right;
        }

        .company-name {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 3px;
        }

        /* Customer and details section */
        .details-section {
            margin-bottom: 25px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .details-table td {
            vertical-align: top;
            padding: 0;
        }

        .invoice-to h2, .invoice-details h2 {
            font-size: 14px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }

        .customer-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 3px;
            font-size: 13px;
        }

        .invoice-details {
            text-align: right;
        }

        .status {
            font-size: 14px;
            font-weight: 700;
            color: #16a34a;
            margin-top: 8px;
        }

        /* Summary section */
        .summary {
            margin-bottom: 25px;
        }

        .summary h2 {
            font-size: 15px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 5px;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 8px 5px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .summary-table .label {
            text-align: left;
            width: 60%;
        }

        .summary-table .value {
            text-align: right;
            width: 40%;
            font-weight: 600;
        }

        .total-row {
            font-weight: 800;
            font-size: 14px;
            color: #2563eb;
            border-top: 2px solid #333;
            border-bottom: none !important;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }

        /* Utility classes */
        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: 700;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .notes-section {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
<div class="invoice-container">
    <!-- Header -->
    <header class="header">
        <table class="header-table">
            <tr>
                <td>
                    <h1>INVOICE</h1>
                    <p class="invoice-number">#{{ $invoice->invoice_number }}</p>
                </td>
                <td class="company-info">
                    <p class="company-name">{{ $company['name'] }}</p>
                    <p>{{ $company['address'] }}</p>
                    <p>Email: {{ $company['email'] }}</p>
                    <p>Phone: {{ $company['phone'] }}</p>
                </td>
            </tr>
        </table>
    </header>

    <!-- Customer and Invoice Details -->
    <div class="details-section">
        <table class="details-table">
            <tr>
                <td width="50%">
                    <div class="invoice-to">
                        <h2>INVOICE TO:</h2>
                        <p class="customer-name">{{ $invoice->user?->name ?? 'Customer Name' }}</p>
                        <p>{{ $invoice->user?->email ?? 'N/A' }}</p>
                    </div>
                </td>
                <td width="50%">
                    <div class="invoice-details">
                        <h2>INVOICE DETAILS</h2>
                        <p><strong>Invoice ID:</strong> {{ $invoice->invoice_number }}</p>
                        <p><strong>Issue Date:</strong> {{ $invoice->issue_date->format('M d, Y') }}</p>
                        <p class="status">Status: {{ strtoupper($invoice->status) }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Summary Section -->
    <div class="summary">
        <h2>SUMMARY</h2>
        <table class="summary-table">

            <tr>
                <td class="label">Subtotal (Pre-Tax):</td>
                <td class="value">${{ number_format($invoice->amount, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Tax Amount:</td>
                <td class="value">${{ number_format($invoice->tax_amount, 2) }}</td>
            </tr>
            <tr>
                <td class="label total-row">INVOICE TOTAL:</td>
                <td class="value total-row">${{ number_format($invoice->total_amount, 2) }}</td>
            </tr>
        </table>

        @if($invoice->notes ?? false)
            <div class="notes-section">
                <h3 style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 13px;">Notes:</h3>
                <p style="font-size: 11px; color: #6b7280;">{{ $invoice->notes }}</p>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="footer">
        Thank you for your business. Please contact us if you have any questions.
    </footer>
</div>
</body>
</html>
