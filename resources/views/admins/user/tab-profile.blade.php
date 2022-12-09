<div class="mb-3 mt-3 row">
    <label for="email" class="col-2 form-label">Email</label>
    <div class="col-10">
        @if($data->type == 'profile')
            <input type="text" class="form-control" readonly id="email" name="email" value="{{$data->email}}">
        @else
            <input type="email" class="form-control @if($data->id == '') validate @endif" @if($data->id != '') readonly @endif id="email" name="email" placeholder="Email" value="{{$data->email}}">
            <div class="invalid-feedback" id="emailerror">
                Please provide a valid email.
            </div>
        @endif
    </div>
</div>
<div class="mb-3 row">
    <label for="password" class="col-2 form-label">Password</label>
    <div class="col-10">
        <input type="password" class="form-control @if($data->id == '') validate @endif" id="password" name="password">
        <div id="emailHelp" class="form-text">Password เฉพาะตัวอักษรภาษาอังกฤษ และตัวเลข ต้องผสมตัวใหญ่ ตัวเล็ก และตัวเลข</div>
        <div class="invalid-feedback" id="passerror">
            Please provide a valid password.
        </div>
    </div>
</div>
<div class="mb-3 row">
    <label for="confirmpassword" class="col-2 form-label">Confirm Password</label>
    <div class="col-10">
        <input type="password" class="form-control @if($data->id == '') validate @endif" id="confirmpassword" name="confirmpassword">
        <div class="invalid-feedback" id="cfpasserror">
            Please provide a valid confirm password.
        </div>
    </div>
</div>
<div class="mb-3 row">
    <label for="firstname" class="col-2 form-label">Firstname</label>
    <div class="col-10">
        <input type="text" class="form-control validate" id="firstname" name="firstname" placeholder="Firstname" value="{{$data->firstname}}">
        <div class="invalid-feedback">
            Please provide a valid Firstname.
        </div>
    </div>
</div>
<div class="mb-3 row">
    <label for="lastname" class="col-2 form-label">Lastname</label>
    <div class="col-10">
        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname" value="{{$data->lastname}}">
        <div class="invalid-feedback">
            Please provide a valid Lastname.
        </div>
    </div>
</div>
<div class="mb-3 row">
    <label for="role" class="col-2 col-form-label">Role</label>
    <div class="col-10">
        @if($data->type == 'profile')
            <input type="text" class="form-control" readonly id="role" name="role" value="{{$data->role}}">
        @else
        <select class="form-select" name="role" id="role">
            @foreach ($roles as $role)
                <option value="{{$role->name}}" @if($role->name == $data->role) selected  @endif>{{$role->name}}</option>
            @endforeach
        </select>
        @endif
    </div>
</div>
<div class="mb-3 row @if($data->type == 'profile') d-none @endif">
    <div class="col-10 offset-2">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="active" name="active" @if($data->active) checked @endif>
            <label class="form-check-label" for="active">Active</label>
          </div>
    </div>
</div>
<div class="mb-3 row @if($data->type == 'profile') d-none @endif">
    <div class="col-10 offset-2">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="default" name="default" @if($data->default) checked @endif>
            <label class="form-check-label" for="default">Public Pseudonym</label>
          </div>
    </div>
</div>
