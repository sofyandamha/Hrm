@extends('layouts.admin')
@section('title')
    <title>My Profile</title>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>My Profile</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card author-box card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="author-box-center">
                                            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle author-box-picture">
                                            <div class="clearfix"></div>
                                            <div class="author-box-name mt-2">
                                                <a href="#">Nama Lengkap</a>
                                            </div>
                                            <div class="author-box-job">Employee Id</div>
                                            <div class="author-box-job">Department => Jobs</div>
                                        </div>
                                    </div>
                                    <div class="row col-12 col-sm-12 col-md-8">
                                        <div class="col-lg-6">
                                            <div class="row-table row-flush mb-2">
                                                <span>1 / 17</span> <br>
                                                <span>Monthly Attendance</span> <br>
                                                <span><small><a href="https://ultimate.codexcube.com/admin/attendance/attendance_report"
                                                    class="mt0 mb0">More info <i
                                                      class="fa fa-arrow-circle-right"></i></a>
                                                </small></span>
                                            </div>
                                            <div class="row-table">
                                                <span>0</span> <br>
                                                <span>Monthly Leave</span> <br>
                                                <span><small><a href="https://ultimate.codexcube.com/admin/attendance/attendance_report"
                                                    class="mt0 mb0">More info <i
                                                      class="fa fa-arrow-circle-right"></i></a>
                                                </small></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row-table row-flush mb-2">
                                                <span>1 / 17</span> <br>
                                                <span>Monthly Absent</span> <br>
                                                <span><small><a href="https://ultimate.codexcube.com/admin/attendance/attendance_report"
                                                    class="mt0 mb0">More info <i
                                                      class="fa fa-arrow-circle-right"></i></a>
                                                </small></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="profile-widget">
                                            <div class="profile-widget-header">
                                                <div class="profile-widget-items">
                                                    <div class="profile-widget-item">
                                                        <div class="profile-widget-item-label">Information 1</div>
                                                        <div class="profile-widget-item-value">187</div>
                                                    </div>
                                                    <div class="profile-widget-item">
                                                        <div class="profile-widget-item-label">Information 2</div>
                                                        <div class="profile-widget-item-value">6,8K</div>
                                                    </div>
                                                    <div class="profile-widget-item">
                                                        <div class="profile-widget-item-label">Information 3</div>
                                                        <div class="profile-widget-item-value">2,1K</div>
                                                    </div>
                                                    <div class="profile-widget-item">
                                                        <div class="profile-widget-item-label">Information 4</div>
                                                        <div class="profile-widget-item-value">2,1K</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-lg-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-3">
                                        <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#basicdetails" role="tab" aria-controls="basicdetails" aria-selected="true">Basic Details</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#bankdetails" role="tab" aria-controls="bankdetails" aria-selected="false">Bank Details</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#documentdetails" role="tab" aria-controls="documentdetails" aria-selected="false">Documents Details</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#salarydetails" role="tab" aria-controls="salarydetails" aria-selected="false">Salary Details</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#timecarddetails" role="tab" aria-controls="timecarddetails" aria-selected="false">Timecard Details</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#leavedetails" role="tab" aria-controls="leavedetails" aria-selected="false">Leave Details</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-9">
                                        <div class="tab-content no-padding" id="myTab2Content">
                                            <div class="tab-pane fade show active" id="basicdetails" role="tabpanel" aria-labelledby="home-tab4">
                                                Basic Details
                                            </div>
                                            <div class="tab-pane fade" id="bankdetails" role="tabpanel" aria-labelledby="profile-tab4">
                                                Bank Details
                                            </div>
                                            <div class="tab-pane fade" id="documentdetails" role="tabpanel" aria-labelledby="contact-tab4">
                                                Document Details
                                            </div>
                                            <div class="tab-pane fade" id="salarydetails" role="tabpanel" aria-labelledby="contact-tab4">
                                                Salary Details
                                            </div>
                                            <div class="tab-pane fade" id="timecarddetails" role="tabpanel" aria-labelledby="contact-tab4">
                                                Timecard Details
                                            </div>
                                            <div class="tab-pane fade" id="leavedetails" role="tabpanel" aria-labelledby="contact-tab4">
                                                Leave Details
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
