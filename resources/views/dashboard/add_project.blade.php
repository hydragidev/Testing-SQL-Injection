@extends('layouts.dashboard_layout')
@section('title', 'Add Project')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
@endsection
@section('content')

    <h1>Add Project</h1>
    <hr>
    <form action="{{ route('dashboard.process_import_project')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Name Project</label>
            <input type="text" required class="form-control" id="exampleFormControlInput1" placeholder="Name Project" style="width: 50%" name="name_project">
        </div>
        <label for="exampleFormControlInput1" class="form-label">Import File</label>
        <div class="input-group" style="width: 50%">
            <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="file_postman" >
            <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04">
                <img src="{{ url('/assets/images/logos/postman.svg')}}" width="20" alt="" />
                &nbsp;
                Import Postman
            </button>
          </div>
    </form>
    <hr>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif
    @if(session('info_endpoint'))
        {{-- {{ json_encode(session('info_endpoint'))}} --}}
        <div class="card w-100">
            <div class="card-body p-4">
                <a href="{{ route('dashboard.reset_project') }}" class="btn btn-info float-end mb-3"><i class="ti ti-refresh"></i>&nbsp;Reset</a>
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
                        $items = session('info_endpoint')['postman']['item'];
                        // dd($items)
                    @endphp
                    @foreach ($items as $item)
                        <tr>
                            <td class="border-bottom-0"><h6 class="fw-semibold mb-0">{{ ++$no }}</h6></td>
                            <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-1">{{ $item['name']}} </h6>                         
                            </td>
                            <td class="border-bottom-0">
                                @php
                                    $method = strtolower($item['request']['method']);
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
                                    {{ $item['request']['method'] }}
                                </span>
                            </td>
                            <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-1">{{ $item['request']['url']['raw']}}</h6>
                                @if($item['request']['method'] == "POST")
                                    <p>
                                        <span>Body type : {{ $item['request']['body']['mode'] ?? '' }}</span>
                                        <br><br>
                                        <code style="background-color: rgb(211, 211, 211); padding: 2px 4px; border-radius: 3px; color: black; padding: 10px;">
                                            {{ $item['request']['body']['raw'] ?? '' }}
                                        </code>
                                    </p> 
                                @endif
                            </td>
                        </tr>   
                    @endforeach  
                    @php 
                        $no = 0;
                        $itemss = session('info_endpoint')['postman']['item'];
                        // dd(session('info_endpoint'))
                    @endphp               
                </tbody>
                
                </table>
              </div>
            </div>
        </div>
    @endif
@endsection
