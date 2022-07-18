@extends('admins.template.template')
@section('title')
File Manager - Files
@endsection
@section('stylesheet')
@endsection
@section('content')
<div class="container-fluid px-4">
    <iframe src="/laravel-filemanager?type=Files" style="width: 100%; height: 85vh; overflow: hidden; border: none;"></iframe>
</div>
@endsection
@section('script')
<script>

</script>
@endsection
