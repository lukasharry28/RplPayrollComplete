<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            text-align: center;
            padding: 5px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h3>Data Penggajian</h3>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Detail Pegawai</th>
                <th>Rekening</th>
                <th>Posisi</th>
                <th>Tanggal Pay</th>
                <th>Gaji</th>
                <th>Tunjangan</th>
                <th>Pajak</th>
                <th>Potongan</th>
                <th>Status Payroll</th>
                <th>Total Gaji</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payrolls as $index => $payroll)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</td>
                <td>{{ $payroll->employee->rekening->no_rekening }}</td>
                <td>{{ $payroll->employee->position->title }}</td>
                <td>{{ $payroll->date }}</td>
                <td>{{ number_format($payroll->employee->salary, 2) }}</td>
                <td>{{ number_format($payroll->employee->tunjangan->rate_amount, 2) }}</td>
                <td>{{ number_format($payroll->employee->pajak->tax_amount, 2) }}</td>
                <td>{{ number_format($payroll->employee->deduction->amount, 2) }}</td>
                <td>{{ $payroll->payroll_status }}</td>
                <td>{{ number_format($payroll->total_amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
