@extends('admins.template.template')
@section('title')
    Contact
@endsection
@section('meta')

@endsection
@section('stylesheet')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link href="{{asset('css/form.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="container-fluid mt-3">
    <div class="h3 border-bottom border-primary text-primary">
        Contact : {{$contact->fullname}}
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form>
                <div class="row mt-2">
                    <div class="col-12 text-end mb-3">
                        <a href="{{ route('contactindex') }}" class="btn btn-outline-primary btn-sm">Back</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="fullname" class="col-2 col-form-label">Fullname</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="fullname" name="fullname" value="{{$contact->fullname}}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-md-2 col-12 col-form-label">Email</label>
                    <div class="col-md-4 col-12">
                        <input type="text" class="form-control" id="email" name="email" value="{{$contact->email}}" readonly>
                    </div>
                    <label for="phone" class="col-md-2 col-12 col-form-label">Phone</label>
                    <div class="col-md-4 col-12">
                        <input type="text" class="form-control" id="phone" name="phone" value="{{$contact->phone}}" readonly>
                    </div>
                </div>
                @if($contact->contacttype == 'job')
                <div class="row mb-3">
                    <label for="position" class="col-md-2 col-12 col-form-label">Position</label>
                    <div class="col-md-4 col-12">
                        <input type="text" class="form-control" id="position" name="position" value="{{$contact->position}}" readonly>
                    </div>
                    <label for="fullname" class="col-md-2 col-12 col-form-label">CV</label>
                    <div class="col-md-4 col-12">
                        <a href="{{url($contact->cv)}}" target="_blank">View</a>
                    </div>
                </div>
                @else
                    <div class="row mb-3">
                        <label for="company" class="col-sm-2 col-form-label">Company</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="company" name="company" value="{{$contact->company}}" readonly>
                        </div>
                    </div>
                @endif
                <div class="row mb-3">
                    <label for="message" class="col-sm-2 col-form-label">Message</label>
                    <div class="col-md-10">
                        <textarea class="form-control" id="message" name="message" rows="10" readonly>{{$contact->message}}</textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="message" class="col-sm-2 col-form-label">Date</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="date" name="date" value="{{$contact->createat}}" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/validate.js')}}"></script>
@endsection
