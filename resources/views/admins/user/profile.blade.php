@extends('admins.template.template')
@section('title')
    Profile
@endsection
@section('meta')

@endsection
@section('stylesheet')
<style>
    #displaythumbnail {
        height: 100px;
    }
    .penname-image {
        height: 50px;
    }
</style>
@endsection
@section('content')
<div class="container-fluid mt-5">
    <div class="h3 border-bottom border-primary text-primary">
        Profile : {{$data->firstname}} {{$data->lastname}}
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="profileform" action="#">
                <div class="mb-3">
                    <div class="col-12 mt-2 text-end">
                        <button name="submitbtn" id="submitbtn" class="btn btn-outline-primary btn-sm" type="button" onclick="javascript:buildData('save');">Save</button>
                    </div>
                </div>
                <ul class="nav nav-tabs">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="config-tab" data-bs-toggle="tab" data-bs-target="#profiletab" type="button" role="tab" aria-controls="profiletab" aria-selected="true">Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pennametab-tab" data-bs-toggle="tab" data-bs-target="#pennametab" type="button" role="tab" aria-controls="pennametab" aria-selected="false">Pseudonym</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="profiletab" role="tabpanel" aria-labelledby="profiletab-tab">
                        @include('admins.user.tab-profile')
                    </div>
                    <div class="tab-pane fade" id="pennametab" role="tabpanel" aria-labelledby="pennametab-tab">
                        @include('admins.user.tab-penname')
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
  <!-- Penname -->
  <div class="modal fade" id="pennameModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pennameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
            <input type="hidden" id="m-pid"/>
            <input type="hidden" id="m-pversion"/>
            <input type="hidden" id="m-mid"/>
            <input type="hidden" id="m-mversion"/>
            <h5 class="modal-title" id="pennameModalLabel">Pseudonym</h5>
        </div>
        <div class="modal-body">
            <div class="mb-3 row">
                <label for="m-penname" class="col-2 form-label">Name</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="m-penname" placeholder="penname">
                    <div class="invalid-feedback">
                        Please provide a valid Name.
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="m-title" class="col-2 form-label">Title</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="m-title" placeholder="Title">
                    <div class="invalid-feedback">
                        Please provide a valid Title.
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="m-description" class="col-2 form-label">Description</label>
                <div class="col-10">
                    <textarea id="m-description" name="m-description" class="form-control"></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="fileupload" class="col-2 form-label">Image</label>
                <div class="col-4">
                    <input type="file" class="form-control" id="fileupload" name="fileupload">
                    <div id="fileuploadFeedback" class="invalid-feedback">
                        Please use image file.
                    </div>
                    <div class="progress mt-2 d-none" id="progress">
                        <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p id="complete" class="d-none text-success">complete</p>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-outline-info btn-sm" id="btn_upload">Upload</button>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-10 offset-2">
                    <img id="displaythumbnail" class="img-thumbnail d-none"/>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="btn-modal-pn-cancel" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="btn-modal-save">Save</button>
          </div>
      </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{asset('js/validate.js')}}"></script>
    @include('admins.user.script')
@endsection
