@extends('adminlte::page')

@section('title', 'NEITIC formations | Dashboard')

@section('content_header')
   <h1 class="font-weight-bold">DASHBOARD</h1>
   <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="public/home">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
    </div>
@stop

@section('content')
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-12 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-info">
            <h4 class="text-center">ETUDIANTS</h4>
          <div class="inner d-flex justify-content-between">
              <div>
                    <h3 id="actuel">{{$actualStudentsCount}}</h3>
                    <p>Actuel(s) <a href="student" class="text-light"><i class="fa fa-arrow-circle-right"></i></a></p>
              </div>
              <div>
                  <h3 id="ancien">{{$oldStudentsCount}}</h3>
                  <p>Ancien(s) <a href="student/old" class="text-light"><i class="fa fa-arrow-circle-right"></i></a></p>
              </div>
          </div>
          <div class="icon">
            <i class="ion ion-ios-people"></i>
          </div>
          <a href="student" class="small-box-footer">More Info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-6 col-xs-6" id="certificate">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{$certifiedStudentsCount}}</h3>

            <p>Etudiant(s) Certifié(s)</p> 
          </div>
          <div class="icon">
            <i class="ion-university"></i>
          </div>
          <a href="student/certified" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-6 col-xs-6" id="paiement">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>{{$studentsWithFeeProblems}}</h3>

            <p>Etudiant(s) en Retard de Paiement</p>
          </div>
          <div class="icon">
            <i class="ion-social-euro"></i>
          </div>
          <a href="fee-problems" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-12 col-xs-12" id="vague">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>{{$countActualSessions}}</h3>

            <p>Vague Actuelle</p>
          </div>
          <div class="icon">
            <i class="ion-ios-refresh"></i>
          </div>
          <a href="formation/sessions" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
  </section>
<style type="text/css">
.col-lg-6 {
    flex: 0 0 50%;
    max-width: 50%;
}
.row {
    margin-right: 202.5px;
    margin-left: 232.5px;
    width: 72%;
}
.col-lg-12 {
    max-width: 30%;
    margin-left: 399px;
    position: fixed;
}
.col-lg-6 {
    max-width: 30%;
    margin-top: 171px;
    position: fixed;
}
.col-sm-6 {
    margin-left: 539px;
    position: relative;
    top: -31px;
}
#certificate{
  margin-left: 60px;
}
#paiement{
  margin-left: 734px;
}
#ancien{
  margin-left: 25px;
}
#actuel{
  margin-left: 4px;
}
#vague {
    margin-top: 348px;
}
.font-weight-bold {
    font-weight: 600 !important;
}
.content{
    position: fixed;
    width: 108%;
    margin-left: -151px;
    margin-top: -25px;
}
.small-box .icon > i {
    font-size: 75px;
    position: absolute;
    right: 15px;
    top: -2px;
    transition: all 0.3s linear;
}
.small-box .icon > i.fa, .small-box .icon > i.fas, .small-box .icon > i.far, .small-box .icon > i.fab, .small-box .icon > i.glyphicon, .small-box .icon > i.ion {
    font-size: 70px;
    top: 20px;
    position:absolute;
    margin-right: 110px;
}
.small-box {
   width: 78%;
}
.small-box:hover .icon > i {
    font-size: 85px;
    color:white;
}
h4, .h4 {
    font-size: 20px;
    position: absolute;
    margin-left: 96px;
    margin-top: 7px;
}
h3, .h3 {
    margin-right: 8px;
}
@media (max-width: 1024px){
.bg-info, .bg-info > a {
    margin-left: -144px;
    width: 118%;
}
.small-box > .small-box-footer {
    margin-left: 4px;
    width: 302px;
}
.bg-green, .bg-green > a {
  margin-left: 195px;
  width: 118%;
}
.bg-red, .bg-red > a {
  margin-left: -107px;
  width: 118%;
}
.content {
    position: absolute;
}
.col-lg-12 {
    max-width: 32%;
}
.col-lg-6 {
    max-width: 32%;
}
#vague {
    margin-top: 22px;
    margin-left: 258px;
    max-width: 37%;
}
}
  </style>
@stop

@section('css')

@stop

@section('js')
    <script></script>
@stop