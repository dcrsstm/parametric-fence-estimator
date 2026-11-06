<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Estimation Summary</title>
</head>
<body style="font-family: sans-serif; margin: 40px;">

    <h2>Perimeter Fence Estimation Summary</h2>
    <p>Total Wall Surface Area: <strong>{{ $wallArea }} sq.m</strong></p>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 700px;">
        <thead>
            <tr style="background: #f0f0f0;">
                <th>Item Description</th>
                <th style="text-align: right;">Quantity / Amount</th>
                <th>Unit</th>
            </tr>
        </thead>
        <tbody>
            <!-- BOQ -->
            <tr style="background: #fafafa; font-weight: bold;">
                <td colspan="3">1. Bill of Quantities (Materials)</td>
            </tr>
            <tr>
                <td>Concrete Hollow Blocks (CHB 150mm)</td>
                <td style="text-align: right;">{{ number_format($totalCHB) }}</td>
                <td>pcs</td>
            </tr>
            <tr>
                <td>Portland Cement</td>
                <td style="text-align: right;">{{ number_format($totalCement) }}</td>
                <td>bags</td>
            </tr>
            <tr>
                <td>Sand</td>
                <td style="text-align: right;">{{ number_format($totalSand, 2) }}</td>
                <td>cu.m</td>
            </tr>
            <tr>
                <td>Gravel</td>
                <td style="text-align: right;">{{ number_format($totalGravel, 2) }}</td>
                <td>cu.m</td>
            </tr>

            <!-- Labor & Schedule -->
            <tr style="background: #fafafa; font-weight: bold;">
                <td colspan="3">2. Labor & Schedule</td>
            </tr>
            <tr>
                <td>Estimated Duration</td>
                <td style="text-align: right;">{{ $estimatedDays }}</td>
                <td>days</td>
            </tr>
            <tr>
                <td>Skilled Mason</td>
                <td style="text-align: right;">{{ $masonsNeeded }}</td>
                <td>person</td>
            </tr>
            <tr>
                <td>General Laborer</td>
                <td style="text-align: right;">{{ $laborersNeeded }}</td>
                <td>person</td>
            </tr>

            <!-- Financial Breakdown -->
            <tr style="background: #fafafa; font-weight: bold;">
                <td colspan="3">3. Financial Breakdown</td>
            </tr>
            <tr>
                <td>Direct Material Cost</td>
                <td style="text-align: right;">{{ number_format($materialCost, 2) }}</td>
                <td>PHP</td>
            </tr>
            <tr>
                <td>Direct Labor Cost</td>
                <td style="text-align: right;">{{ number_format($laborCost, 2) }}</td>
                <td>PHP</td>
            </tr>
            <tr style="font-weight: bold;">
                <td>Direct Cost Subtotal</td>
                <td style="text-align: right;">{{ number_format($directCost, 2) }}</td>
                <td>PHP</td>
            </tr>
            <tr>
                <td>OCM (12%)</td>
                <td style="text-align: right;">{{ number_format($ocm, 2) }}</td>
                <td>PHP</td>
            </tr>
            <tr>
                <td>Contractor Profit (8%)</td>
                <td style="text-align: right;">{{ number_format($profit, 2) }}</td>
                <td>PHP</td>
            </tr>
            <tr>
                <td>Value-Added Tax (12%)</td>
                <td style="text-align: right;">{{ number_format($vat, 2) }}</td>
                <td>PHP</td>
            </tr>
            <tr style="font-weight: bold; background: #e6ffe6;">
                <td>Final Estimated Contracting Fee</td>
                <td style="text-align: right;">{{ number_format($finalFee, 2) }}</td>
                <td>PHP</td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top: 20px;">
        <a href="/">Back to Calculator</a>
    </p>

</body>
</html>
