@extends('dashboard.layouts.master')
@section('title', 'Registrar Dashboard')
@section('sidebar')
    @include('dashboard.registrar.inc.sidebar')
@endsection

@section('content-header')
    <section class="content-header">
        <h1>
            <small>Section:</small>
            {{ $section_name = \App\Section::find(request()->segment(3))->name }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{'/'.request()->segment(1) }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">{{ request()->segment(2) }}</li>
            <li class="active">{{ $section_name }}</li>
        </ol>
    </section>
@endsection

@section('content-main')
    <!-- Main content -->
    <section class="content container-fluid">

        <div class="row" id="teachers-table">
            <div class="col-lg-12">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }} </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            <!-- menu bar -->
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search level">
                </div>
                <div class="form-horizontal form-group">
                    <button v-on:click="showAddModal('subject')" class="btn btn-default" title="add section"><i class="fa fa-plus fa-lg"></i></button>
                </div>
                <!-- ./menu bar-->

                @isset($subjects)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">Subjects</th>
                                <th class="text-center">Teacher</th>
                                <th colspan="10" class="text-center">Action</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($subjects as $subject)
                                <tr>
                                    <td>{{++$index}}</td>
                                    <td>{{$subject->name}}</td>
                                    <td>{{$subject->teacher->first_name}} {{$subject->teacher->middle_name}} {{$subject->teacher->last_name}}</td>
                                    <td>
                                        <button class="btn btn-info" ><i class="fa fa-edit fa-lg"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                @endisset
            </div>
        </div>

        <div>
            <!--edit modal-->
            <div class="modal fade" id="edit-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Edit Student</h4>
                        </div>
                        <form action="{{ route('update.student') }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <div class="modal-body">

                                <div id="edit-modal-body">
                                    <modal-edit-form v-for="(item, key) in responses" :form-name="key" :form-data="item" :is-id="checkIfId(key)"></modal-edit-form>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /. edit modal -->

            <!-- add modal -->
            <div class="modal fade" id="add-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Add Subject</h4>
                        </div>
                        <form action="{{ route('add.subject') }}" method="post">
                            {{ csrf_field() }}
                            <div class="modal-body">

                                <div id="add-modal-body">
                                    <modal-add-form v-for="(type, field) in fields" :options="subjectFields" :extra-options="{'subject-name': 'text'}" :form-name="field" :form-type="type"></modal-add-form>
                                </div>

                                <input type="hidden" name="sectionId" value="{{ request()->segment(3) }}">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /. add modal -->

            <!-- delete modal -->
            <div class="modal fade" id="delete-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Delete Student</h4>
                        </div>

                        <div id="delete-modal-body">
                            <form :action="deleteLink" method="post">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                <div class="modal-body" v-text="username">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div><!-- /. delete modal -->

        </div>

    </section>
    <!-- /.content -->
@endsection

@section('sidebar-control')
    @include('dashboard.registrar.inc.sidebar-control')
@endsection