@extends('admins.template.template')
@section('title')
    Content
@endsection
@section('meta')

@endsection
@section('stylesheet')

@endsection
@section('content')
<div class="container mt-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Contact : {{$contact->fullname}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form>
                <div class="row mb-3">
                    <label for="fullname" class="col-sm-2 col-form-label">Fullname</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="fullname" name="fullname" value="{{$contact->fullname}}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="email" name="email" value="{{$contact->email}}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="phone" name="phone" value="{{$contact->phone}}" readonly>
                    </div>
                </div>
                @if($contact->contact_type == 'job')
                <div class="row mb-3">
                    <label for="position" class="col-sm-2 col-form-label">Position</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="position" name="position" value="{{$position}}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="fullname" class="col-sm-2 col-form-label">CV</label>
                    <div class="col-md-10">
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
                        <textarea class="form-control" id="message" name="message" rows="4">{{$contact->message}}</textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="message" class="col-sm-2 col-form-label">Date</label>
                    <div class="col-md-10">
                        <?php
                            $date = new Datetime($contact->created_at);
                            $date->setTimezone(new DateTimeZone('+7.0'));
                        ?>
                        <input type="text" class="form-control" id="company" name="company" value="{{date_format($date,'d/m/Y H:i')}}" readonly>
                    </div>
                </div>

                <hr class="mb-4">
                <div class="row mb-3">
                    <div class="col-12 pb-2">
                        <a href="{{ route('contactindex') }}" class="btn btn-outline-primary btn-sm">Back</a>
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
