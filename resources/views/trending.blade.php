@inject('trending', 'App\Helpers\Trending')

@php
    $trendings = $trending::weekly();
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Trending</div>
                    <div class="card-body">
                        @if($trendings->count())
                            <ul>
                                @foreach($trendings as $key => $each)
                                   <li>
                                        <div class="article">
                                            <a href="{{ asset($each->url) }}" title="{{ $each->views }}">
                                                <span class="text-muted">{{ $each->tweet->created_at->format('d M, Y') }}</span><br>
                                                {{ $each->tweet->body }}
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
