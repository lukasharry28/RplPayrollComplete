@extends('admin.layout.app')

@section('title') Company Profile - Dashboard @endsection

@section('css')
<style type="text/css">
    .profile-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        background-color: #fff;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .profile-header {
        background-color: #fff;
        padding: 30px;
        /* border: 1px solid #ddd; */
        border-radius: 8px;
        flex: 0 0 30%; /* Adjust size as needed */
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .profile-avatar {
        width: 180px;
        height: 180px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #007bff;
        margin-bottom: 20px;
    }

    .profile-details {
        text-align: center;
    }

    .profile-details h3 {
        margin-top: 0;
        font-size: 1.8em;
    }

    .profile-details p {
        margin: 8px 0;
    }

    .details-section {
        flex: 1;
        min-width: 60%; /* Adjust size as needed */
    }

    .card-title {
        font-size: 1.5em;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .form-value {
        margin-bottom: 15px;
        font-size: 1.1em;
    }

    .profile-tabs .nav-link {
        border-radius: 0;
        color: #007bff;
        font-weight: 500;
        margin-bottom: 30px;
    }

    .profile-tabs .nav-link.active {
        background-color: #007bff;
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <h2 class="page-title">Company Profile</h2>
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="/dashboard">Dashboard</a>
            <span class="breadcrumb-item active">Profile</span>
            <span class="breadcrumb-item active">PT. Miaw Payroll</span>
        </nav>
    </div>

    <div class="profile-container">
        <div class="profile-header">
            <img src="{{ asset('admin_assets/tile.png') }}" alt="Company Logo" class="profile-avatar">
            <div class="profile-details">
                <h3>{{ $company->company_name }}</h3>
                <p><strong>Email:</strong> {{ $company->email }}</p>
                <p><strong>Phone:</strong> {{ $company->phone }}</p>
                <p><strong>Address:</strong> {{ $company->address }}</p>
            </div>
        </div>
        <div class="details-section">
            <div class="cards">
                <div class="card-body">
                    <ul class="nav nav-pills profile-tabs" id="profile-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="details-tab" data-toggle="pill" href="#details"
                               role="tab" aria-controls="details" aria-selected="true">Company Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="history-tab" data-toggle="pill" href="#history" role="tab"
                               aria-controls="history" aria-selected="false">Company Rekening</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="team-tab" data-toggle="pill" href="#team" role="tab"
                               aria-controls="team" aria-selected="false">Our Team</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" id="team-tab" data-toggle="pill" href="#team" role="tab"
                               aria-controls="team" aria-selected="false">Our Team</a>
                        </li> --}}
                    </ul>
                    <div class="tab-content" id="profile-tabContent">
                        <div class="tab-pane fade show active" id="details" role="tabpanel"
                             aria-labelledby="details-tab">
                            <div class="form-group">
                                <label class="form-label">Company Overview</label>
                                <p class="form-value">Kami adalah perusahan dalam bidang penyedia software.</p>

                                <label class="form-label">Mission</label>
                                <p class="form-value">Misi kami adalah memajukan indonesia maju dengan merekrut karyawan dari indonesia tidak lain untuk memajukan bangsa.</p>

                                <label class="form-label">Vision</label>
                                <p class="form-value">Visi kami adalah tercapainya indonesia emas 45 dengan era thecnologi.</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                            <p class="form-value">Detail List about the company's rekening.</p>
                            <p>
                                <img src="{{ asset('admin_assets/avatars/bank/' . strtolower($company->rekening->bank->image_name) . '.png') }}"
                                     alt="{{ $company->rekening->bank->bank_name }}"
                                     style="width: 50px; object-fit: cover; margin-right: 10px;">
                                     <b>{{ $company->rekening->no_rekening }}</b>
                            </p>
                            {{-- <p>
                                <img src="{{ asset('admin_assets/avatars/bank/' . strtolower($rekenings->bank->image_name) . '.png') }}"
                                     alt="{{ $rekenings->bank->bank_name }}"
                                     style="width: 50px; object-fit: cover; margin-right: 10px;">
                                     <b>{{ $rekenings->no_rekening }}</b>
                            </p> --}}
                        </div>
                        <div class="tab-pane fade" id="team" role="tabpanel" aria-labelledby="team-tab">
                            <p class="form-value">Information about the key members of the team and their roles.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    // Custom JavaScript functionality can be added here
</script>
@endsection
