@extends('gallery::dashboard.layouts.app')

@section('title', 'گالری')
@section('content')
    <div class="panel has-table mt-5">
        <div class="table-title">
            <i class="fal fa-newspaper"></i>
            <h3>لیست گالری ها</h3>
            <a class="btn-resource fal fa-plus" title="افزودن گالری"   data-toggle="modal" data-target="#galleryCreate" ></a>
        </div>
        <div class="m-2">
            <a href="{{route('gallery.create')}}" class="btn btn-success">ایجاد گالری</a>
        </div>
        <div class="table-responsive">
            <table id="posts" class="table table-bordered table-hover table-striped text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>عنوان</th>
                    <th>توضیحات</th>
                    <th>تعداد عکس</th>
                    <th>نوع</th>
                    <th>وضعیت </th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @if(count($gallery) > 0)
                    @foreach($gallery as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->title }}</td>
                            <td class="text-trunc">{{ $item->description }}</td>
                            <td><a href="{{route('gallery.edit',['gallery' => $item->id])}}">{{$item->images->count()}}</a></td>
                            <td><a>{{$item->is_private()}}</a></td>
                            <td><a>{{$item->status()}}</a></td>
                            <td>
                                <a href="{{ route('gallery.edit',['gallery' => $item->id]) }}" data-toggle="tooltip" title="مشاهده/ویرایش" class="btn btn-info fa fa-edit">@lang('view and edit')</a>
                                <a onclick="event.preventDefault();document.getElementById('form_delete').submit()" data-toggle="tooltip" title="حذف" class="btn-table-danger fal fa-trash"></a>
                            </td>
                        </tr>
                        <form action="{{route('gallery.destroy',['gallery' => $item->id])}}" id="form_delete" method="post">
                            @csrf
                        </form>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">
                            <i class="fal fa-search"></i>
                            <span>چیزی یافت نشد</span>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('footer-content')

@endsection
@section('head-content')
    <link rel="stylesheet" href="/plugins/datatable/datatables.css">
    <style>
        .buttons-excel,
        .buttons-print,
        .buttons-copy {
            background-color: white !important;
            color: #8e8e8e !important;
            border-radius: 5px !important;
            margin-left: 2px !important;
            font-size: 1em;
        }

        #posts_filter {
            float: left;
        }

        #posts_info {
            float: right;
        }

        #posts_paginate {
            margin: 0 3px;
            float: left;
        }
    </style>
@endsection
