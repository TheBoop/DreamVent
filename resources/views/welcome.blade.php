@extends('layouts.app')

@section('content')
    @if (count($frontpages) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Front Page Of the Interwebs
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <tbody>
                                @foreach ($frontpages as $frontpages)
                                    <tr>
                                        <div class="table table-bordered bg-success">
                                        <li><a href="{{ url('/viewPost/'.$frontpages->picture_id) }}">
                                        <img src="{!! $frontpages->picture_link !!}"/>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
@endsection