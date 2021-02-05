@extends('gallery::dashboard.layouts.app')
@section('head')
    <style type="text/css">
        .gallery
        {
            display: inline-block;
            margin-top: 20px;
        }
        .close-icon{
            border-radius: 50%;
            position: absolute;
            right: 5px;
            top: -10px;
            padding: 5px 8px;
        }
        .form-image-upload{
            background: #e8e8e8 none repeat scroll 0 0;
            padding: 15px;
        }
    </style>
@endsection
@section('title', 'گالری')
@section('content')
<div class="container">
    <h3>گالری : {{$gallery->title}}</h3>
    <form action="{{route('image.gallery.upload') }}" class="form-image-upload" method="POST" enctype="multipart/form-data">
        @csrf
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <input type="hidden" name="gallery_id" value="{{$gallery->id}}">
        <div class="row">
            <div class="col-md-2">
                <br/>
                <button type="submit" class="btn btn-success">ارسال</button>
            </div>
            <div class="col-md-5">
                <strong>عنوان:</strong>
                <input type="text" name="title" class="form-control" placeholder="Title">
            </div>
            <div class="col-md-5">
                <strong>تصویر:</strong>
                <input type="file" name="image" class="form-control">
            </div>
        </div>


    </form>


    <div class="row">
        <div class='list-group gallery' dir="ltr">


            @if($gallery->images->count())
                @foreach($gallery->images as $image)
                    <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                        <a class="thumbnail fancybox" rel="ligthbox" href="{{ $image->url}}">
                            <img class="img-responsive" alt="" src="{{ $image->url }}" />
                            <div class='text-center'>
                                <small class='text-muted'>{{ $image->title }}</small>
                            </div> <!-- text-center / end -->
                        </a>
                        <form action="{{route('image.gallery.delete' ,$image->id)}}" method="POST">
                            <input type="hidden" name="_method" value="delete">
                            {!! csrf_field() !!}
                            <button type="submit" class="close-icon btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
                        </form>
                    </div> <!-- col-6 / end -->
                @endforeach
            @endif


        </div> <!-- list-group / end -->
    </div> <!-- row / end -->
</div> <!-- container / end -->
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $(".fancybox").fancybox({
                openEffect: "none",
                closeEffect: "none"
            });
        });
    </script>
@endsection
