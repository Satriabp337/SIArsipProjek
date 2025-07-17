@extends('layouts.app') {{-- pastikan ini sesuai layout kamu --}}

@section('title', 'Preview Dokumen Excel')

@section('content')
<div class="container">
    <h4 class="mb-4">Preview File Excel</h4>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped align-middle">
            <thead class="table-primary sticky-top">
                @if(isset($data[0]))
                    <tr>
                        @foreach($data[0] as $header)
                            <th>{{ $header }}</th>
                        @endforeach
                    </tr>
                @endif
            </thead>
            <tbody>
                @foreach($data as $index => $row)
                    @if($index === 0) @continue @endif {{-- skip header --}}
                    <tr>
                        @foreach($row as $cell)
                            <td>{!! nl2br(e($cell)) !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
