@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h4>Preview Excel</h4>
        <table class="table table-bordered">
            @foreach($data as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>
@endsection
