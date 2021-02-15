@extends('gallery::dashboard.layouts.app')

@section('title', 'گالری')
@section('head')
    <link href="{{asset('plugins/file-upload/file-upload-with-preview.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<section class="card m-auto">
    <div class="card-body">
        <h5 class="card-title">
            <span>@lang('new gallery')</span>
        </h5>
        <form method="post" action="{{ route('gallery.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mt-3">
                <div class="form-group col-md-6">
                    <label>@lang('name gallery')</label>
                    <input type="text" name="title"
                           class="form-control"
                           value="{{old('title')}}" autocomplete="off" dir="auto" maxlength="50" required/>
                    @error('title')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>@lang('type gallery')</label>
                    <select name="private" class="form-control" id="private" required>
                        <option value="0">@lang('public')</option>
                        <option value="1">@lang('private')</option>
                    </select>
                    @error('private')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>@lang('type publish')</label>
                    <select name="publish" class="form-control" id="publish" required>
                        <option value="1">@lang('publication')</option>
                        <option value="0">@lang('awaiting release')</option>
                    </select>
                    @error('private')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>@lang('description')</label>
                    <textarea class="form-control" name="description" placeholder="@lang('please enter description')">{{old('description')}}</textarea>
                    @error('description')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="custom-file-container bg-6 rounded-lg p-3 my-3" data-upload-id="gallery_images">
                        <label class="d-flex justify-content-between">@lang('gallery image') <a href="javascript:void(0)" class="custom-file-container__image-clear" title="{{Lang::get('clear images')}}">x</a> </label>
                        <label class="custom-file-container__custom-file" >
                            <input name="image" id="iamge" type="file" class="custom-file-container__custom-file__custom-file-input product-input game-input">
                            <input type="hidden" name="MAX_FILE_SIZE4" value="7485760" />
                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                        </label>
                        <div class="custom-file-container__image-preview"></div>
                    </div>
                    @error('images[]')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            <div class="col-md-12 m-2">
                <input name="submit" value="ثبت" class="btn btn-success float-left" type="submit">
            </div>
        </form>
    </div>
</section>
@endsection
@section('script')
    <script src="{{asset('plugins/file-upload/file-upload-with-preview.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            var screenshotsUpload = new FileUploadWithPreview('gallery_images');
        });
    </script>
@endsection
