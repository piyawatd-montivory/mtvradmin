@extends('admins.template.template')
@section('title')
    สินค้า
@endsection
@section('meta')

@endsection
@section('stylesheet')
@endsection
@section('content')
<div class="container-fluid mt-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">สินค้า : {{$product->name}}</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="productform" method="post" action="{{ route('mproductupdate',['id'=>$product->id]) }}">
                <div class="row">
                    <div class="mb-3">
                        <label for="producttype" class="form-label">ประเภทสินค้า</label>
                        <input type="text" value="{{$productType->name}}" class="form-control" readonly/>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="name" class="form-label">ชื่อสินค้า</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="ชื่อสินค้า" value="{{$product->name}}">
                        <div class="invalid-feedback">
                            <h6>โปรดใส่ข้อมูลชื่อสินค้า</h6>
                        </div>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="price" class="form-label">ราคา</label>
                        <input type="number" class="form-control" id="price" name="price" value="{{$product->price}}">
                        <div class="invalid-feedback">
                            <h6>โปรดใส่ข้อมูลราคา</h6>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">รายละเอียด</label>
                        <textarea id="description" name="description" class="form-control">{{$product->description}}</textarea>
                    </div>
                    @foreach ($productType->attributes as $field)
                        <div class="mb-3">
                            <label for="{{$field->name}}" class="form-label">{{$field->label->th}}</label>
                            @switch($field->type->name)
                                @case('text')
                                    <input type="text" class="form-control @if($field->isRequired) validate @endif" id="{{$field->name}}" name="{{$field->name}}"  value="{{$field->data}}">
                                    @if($field->isRequired)
                                        <div class="invalid-feedback"><h6>โปรดใส่ข้อมูล{{$field->label->th}}</h6></div>
                                    @endif
                                    @break
                                @case('number')
                                    <input type="number" class="form-control @if($field->isRequired) validate @endif" id="{{$field->name}}" name="{{$field->name}}"  value="{{$field->data}}">
                                    @if($field->isRequired)
                                        <div class="invalid-feedback"><h6>โปรดใส่ข้อมูล{{$field->label->th}}</h6></div>
                                    @endif
                                    @break
                                @case('reference')
                                    <select class="form-select" id="{{$field->name}}" name="{{$field->name}}">
                                        @foreach ($field->category as $cateObj)
                                            <option value="{{$cateObj->id}}" @selected($field->data == $cateObj->id)>{{$cateObj->name}}</option>
                                        @endforeach
                                    </select>
                                    @break
                            @endswitch
                        </div>
                    @endforeach
                </div>
                <div class="mb-3">
                    <button name="subminbtn" id="subminbtn" class="btn btn-outline-primary btn-sm" type="button" onclick="javascript:submitform();">บันทึก</button>
                    <a href="{{ route('mproductindex') }}" class="btn btn-outline-danger btn-sm">ยกเลิก</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{asset('js/validate.js')}}"></script>
    <script type="text/javascript">
        
        function submitform(){
            var pass = true;
            $.each($('.validate'),function(i,obj){
                if($(obj).val() == ''){
                    $(obj).addClass('is-invalid');
                    pass = false;
                    return false;
                }else{
                    $(obj).removeClass('is-invalid');
                }
            })
            if(pass){
                $('#productform').submit();
            }
        }
    </script>
@endsection
