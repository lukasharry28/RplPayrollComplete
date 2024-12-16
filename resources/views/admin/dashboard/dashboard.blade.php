<?php

$username = "root";
$password = "";
$database = "db_payroll_main";

try {
    $pdo = new PDO("mysql:host=localhost;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM employees";
    $result = $pdo->query($sql);

    $maleCount = 0;
    $femaleCount = 0;

    while ($row = $result->fetch()) {
        if (strtolower($row['gender']) === 'male') {
            $maleCount++;
        } elseif (strtolower($row['gender']) === 'female') {
            $femaleCount++;
        }
    }

    $gender = [$maleCount, $femaleCount];
} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

if (empty($gender)) {
    $gender = [0, 0];
}

?>

@extends('admin.layout.app')

@section('title') Dashboard @endsection

@section('css')
<style type="text/css">
    /* Add custom styles here if needed */
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-bar-chart bg-blue"></i>
                <div class="d-inline">
                    <h5>Dashboard</h5>
                    <span>This is dashboard of the Miaw Pay.</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="../../index.html"><i class="ik ik-home"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-3 col-md-6 col-sm-12 cursor-pointer">
            <a href="#">
                <div class="widget bg-primary">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>Total Employees</h6>
                                <h2>{{ $counts['employees'] }}</h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-5 col-md-6 col-sm-12 cursor-pointer">
            <a href="#">
                <div class="widget bg-warning">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>Tanggal dan Hari Ini</h6>
                                <h2 class="custom-date">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</h2>
                                <!-- Tanggal dan hari -->
                            </div>
                            <div class="icon">
                                <i class="ik ik-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tambahkan CSS -->
        <style type="text/css">
            .custom-date {
                font-size: 25px;
                /* Atur ukuran font sesuai kebutuhan */
                font-weight: bold;
                /* Menambah ketebalan font jika diinginkan */
            }
        </style>


        <div class="col-lg-4 col-md-6 col-sm-12 cursor-pointer">
            <a href="#">
                <div class="widget bg-danger">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>Saldo Rekening Utama</h6>
                                <h3>Rp {{ number_format($saldo_rekening, 0, ',', '.') }}</h3>
                            </div>
                            <div class="icon">
                                <i class="ik ik-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-xl-6 col-md-6 col-sm-12">
            <div class="card latest-update-card">
                <div class="card-header">
                    <h3>Positions</h3>
                    <div class="card-header-right"></div>
                </div>
                <div class="card-block">
                    <div class="scroll-widget">
                        <div class="latest-update-box">
                            @foreach($positions as $position)
                            <div class="row pt-20 pb-30">
                                <div class="col-auto text-right update-meta pr-0">
                                    <i class="b-primary update-icon ring"></i>
                                </div>
                                <div class="col pl-5">
                                    <a href="#!">
                                        <h6>{{ $position->title }}</h6>
                                    </a>
                                    <p class="text-muted mb-0">{{ $position->description }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CHART EMPLOYEE --}}
        <div class="col-xl-6 col-md-6 col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <h3>Gender Employee</h3>
                    <div class="card-header-left"></div>
                </div>
                <div class="card-block pb-0">
                    <div class="table-responsive" style="width: 100%; max-width: 600px; margin: auto;">
                        <canvas id="myChart" width="350" height="400"></canvas>
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                            const gender = <?php echo json_encode($gender); ?>;
                            const chartElement = document.getElementById('myChart');
                            if (chartElement) {
                                const data = {
                                    labels: ['Male', 'Female'],
                                    datasets: [{
                                        label: 'Gender Distribution',
                                        data: gender,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                };

                                const config = {
                                    type: 'pie',
                                    data: data,
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            }
                                        }
                                    }
                                };

                                new Chart(chartElement, config);
                            }
                        });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <h3>Somthing about Deductions </h3>
                    <div class="card-header-right"></div>
                </div>
                <div class="card-block pb-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 without-header">
                            <tbody>
                                @foreach($deductions as $deduction)
                                <tr>
                                    <td>
                                        <h3>{{ number_format($deduction->amount, 2, ',', '.') }}</h3>
                                    </td>
                                    <td>
                                        <p class="font-weight-bold">{{ $deduction->name }}</p>
                                        <p>{{ $deduction->description }}</p>
                                        <code class="pc">{{ $deduction->slug }}</code>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2" class="text-right text-primary">Rp.{{
                                        number_format($total_deduction, 2, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
