@extends('gallery::dashboard.layouts.app')

@section('title', 'گالری')
@section('head')
    <link href="{{asset('plugins/file-upload/file-upload-with-preview.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <section class="card m-auto">
        <div class="card-body">
            <h5 class="card-title">
                <i class="fal fa-building"></i>
                <span>@lang('new gallery')</span>
            </h5>
            <form method="post" action="{{ route('gallery.update' ,['gallery' => $gallery->id]) }}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="row mt-3">
                    <div class="form-group col-md-6">
                        <i class="fal fa-info"></i>
                        <label>@lang('name gallery')</label>
                        <input type="text" name="title"
                               class="form-control"
                               value="{{ old('title') ?: $gallery->title}}" autocomplete="off" dir="auto" maxlength="50" required/>
                    </div>
                    <div class="form-group col-md-6">
                        <i class="fal fa-map-marker-alt"></i>
                        <label>@lang('type gallery')</label>
                        <select name="private" class="form-control" id="cities" required>
                            <option value="0" {{$gallery->private ? '' : 'selected'}}>@lang('public')</option>
                            <option value="1" {{$gallery->private ? 'selected' : ''}}>@lang('private')</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <i class="fal fa-keyboard"></i>
                        <label>@lang('description')</label>
                        <textarea class="form-control" rows="3" name="description" placeholder="@lang('please enter description')">{{old('description') ?: $gallery->description}}</textarea>
                    </div>
                    <div class="col-md-12">
                        <div class="custom-file-container bg-6 rounded-lg p-3 my-3" data-upload-id="gallery_images">
                            <label class="d-flex justify-content-between">@lang('gallery images') <a href="javascript:void(0)" class="custom-file-container__image-clear" title="{{Lang::get('clear images')}}">x</a> </label>
                            <label class="custom-file-container__custom-file" >
                                <input name="images[]" id="iamges" type="file" class="custom-file-container__custom-file__custom-file-input product-input game-input" multiple>
                                <input type="hidden" name="MAX_FILE_SIZE4" value="7485760" />
                                <span class="custom-file-container__custom-file__custom-file-control"></span>
                            </label>
                            <div class="custom-file-container__image-preview"></div>
                        </div>
                    </div>
                    <div class="col-md-12 m-2">
                        <input value="@lang('edit')" class="btn btn-success float-start" type="submit">
                        <a onclick="window.history.back();" class="btn btn-danger float-end">@lang('back')</a>
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
