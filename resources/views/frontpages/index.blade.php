@extends('layouts.app')

@section('content')
    @if (count($frontpages) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Temp User Page
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <tbody>
                                @foreach ($frontpages as $frontpages)
                                    <tr>
                                        <td class="table-text"><div>{{ $frontpages->name }}</div></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
@endsection