@extends('gallery::dashboard.layouts.app')

@section('title', 'گالری')
@section('head')
    <link rel='stylesheet' href='{{asset('plugins/unitegallery/css/unite-gallery.css')}}' type='text/css' />
@endsection
@section('content')
    <div class="mt-4 mt-5">
        <div class="mt-3 d-flex justify-content-center ">
            <div class="d-flex flex-column text-center">
                <h1>{{$gallery->title}}</h1>
                <h4>{{$gallery->description}}</h4>
            </div>
        </div>
        <div id="gallery" style="display:none;direction: rtl !important;background-color: aliceblue !important;" class="bg-success p-2">
            @foreach($gallery->images as $image)
                <a href="http://unitegallery.net">
                    <img class="test" alt="{{$image->title}}"
                         loading="lazy"
                         src="{{$image->image}}"
                         data-image="{{$image->image}}"
                         data-image-mobile="{{$image->image}}"
                         data-thumb-mobile="{{$image->image}}"
                         data-description="{{$image->title}}"
                         style="display:none">
                </a>
            @endforeach
        </div>
        <a href="{{route('gallery.index')}}" class="btn btn-info m-2" style="float:left !important;">@lang('back')</a>
    </div>
@endsection
@section('script')
{{--    <script type='text/javascript' src='{{asset('plugins/unitegallery/js/jquery-11.0.min.js')}}'></script>--}}
    <script type='text/javascript' src='{{asset('plugins/unitegallery/js/unitegallery.min.js')}}'></script>
    <script type='text/javascript' src='{{asset('plugins/unitegallery/themes/tiles/ug-theme-tiles.js')}}'></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("#gallery").unitegallery();

        });
    </script>
@endsection
