@extends('layouts.dashboard_layout')
@section('title', 'Detail Project')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
@endsection
@section('content')
    <h1 class="float-left">{{ $infoNameProject }}</h1>
    <hr>
    <a href="{{ route('dashboard.process_add_project')}}" class="btn btn-danger float-end mb-3" style="background-color: rgb(255, 57, 57);"><i class="ti ti-arrow-back-up"></i> Back</a>
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Endpoint URL</h5>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">No</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Name</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Method</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Endpoint/URL</h6>
                    </th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $no = 0;
                    @endphp
                    @foreach ($infoUrl as $item)
                        <tr>
                            <td class="border-bottom-0"><h6 class="fw-semibold mb-0">{{ ++$no }}</h6></td>
                            <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-1">{{ $item['name_url']}} </h6>                         
                            </td>
                            <td class="border-bottom-0">
                                @php
                                    $method = strtolower($item['method']);
                                    $badgeClass = '';

                                    if ($method == 'get') {
                                        $badgeClass = 'bg-success';
                                    } elseif ($method == 'post') {
                                        $badgeClass = 'bg-warning';
                                    } elseif ($method == 'delete') {
                                        $badgeClass = 'bg-danger';
                                    } elseif ($method == 'options') {
                                        $badgeClass = 'bg-info';
                                    } else {
                                        // Default class jika metode tidak dikenali
                                        $badgeClass = 'bg-secondary';
                                    }
                                @endphp

                                <span class="badge rounded-3 fw-semibold {{ $badgeClass }}">
                                    {{ $item['method'] }}
                                </span>
                            </td>
                            <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-1">{{ $item['url']}}</h6>
                                @if($item['headers'])
                                    <p class="mt-2">HEADER :</p>
                                    <pre>{{ $item['headers'] }}</pre>
                                @endif
                                @if($item['method'] == "POST")
                                    <p class="mt-2">POST DATA :</p>
                                    <code style="background-color: rgb(211, 211, 211); padding: 2px 4px; border-radius: 3px; color: black; padding: 10px;">
                                        {{ $item['post_data'] ?? '' }}
                                    </code> 
                                @endif
                            </td>
                        </tr>   
                    @endforeach               
                </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="{{ route('dashboard.project_launch') }}" class="btn btn-success float-end"><i class="ti ti-rotate-clockwise-2"></i> Launch Scan</a>
@endsection