@extends('dashboard.layouts.main')

@section('title', 'Student Dashboard')

@section('sidebar')
    @include('dashboard.student.sidebar')
@endsection

@section('body')
    <div class="row">
        <p class="text-center h3">Rate your Subject Teachers</p>
    </div>
    <br>
    <div class="row text-center" id="ratings">
        @foreach($student->section->subjects as $subject)
        <div class="col-md-2 col-sm-4">
            <div class="well well-sm">
                <p><strong>{{ $subject->name }}</strong></p>
                <p>{{ $subject->teacher->first_name }} {{ $subject->teacher->last_name }}</p>
                {{--<heart-rating></heart-rating>--}}
                <heart-rating v-on:rating-selected="rate($event, {{ $subject->teacher->id }}, {{ $subject->id }})"
                              :inline="true" :rating="{{ $subject->teacher->rated(auth()->id(), $subject->id) }}" :show-rating="false" :item-size="20" :spacing="3" :max-rating="5"
                              v-on:click="rate"></heart-rating>
                <br>
                {{--<button class="btn btn-success" disabled>Rated <i class="fa fa-check"></i></button>--}}
            </div>
        </div>
        @endforeach
    </div>
@endsection