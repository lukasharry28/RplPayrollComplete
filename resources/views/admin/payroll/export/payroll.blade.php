<!DOCTYPE html>
<html>
<head>
    <title>Payroll Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table, th, td {
            border: 1px solid #000;
            padding: 5px;
        }
        .text-right {
            text-align: right;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Payroll Report</h1>
        <p>Periode: {{ $date }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>ID Karyawan</th>
                <th>Posisi</th>
                <th>Rekening</th>
                <th>Gaji Pokok</th>
                <th>Tunjangan</th>
                <th>Pajak</th>
                <th>Potongan</th>
                <th>Total Gaji</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payrolls as $payroll)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</td>
                <td>{{ $payroll->employee->employee_id }}</td>
                <td>{{ $payroll->employee->position->title }}</td>
                <td>
                    {{ $payroll->employee->rekening->no_rekening }}
                    ({{ $payroll->employee->rekening->bank->bank_name }})
                </td>
                <td class="text-right">{{ number_format($payroll->employee->salary, 2) }}</td>
                <td class="text-right">
                    {{ $payroll->employee->tunjangan->title }}<br>
                    {{ number_format($payroll->employee->tunjangan->rate_amount, 2) }}
                </td>
                <td class="text-right">
                    {{ $payroll->employee->pajak->title }}<br>
                    {{ number_format($payroll->employee->pajak->tax_amount, 2) }}
                </td>
                <td class="text-right">
                    {{ $payroll->employee->deduction->name }}<br>
                    {{ number_format($payroll->employee->deduction->amount, 2) }}
                </td>
                <td class="text-right">{{ number_format($payroll->total_amount, 2) }}</td>
                <td>{{ $payroll->payroll_status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
