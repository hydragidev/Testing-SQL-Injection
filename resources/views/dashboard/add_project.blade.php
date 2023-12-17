@extends('layouts.dashboard_layout')
@section('title', 'Add Project')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
@endsection
@section('content')

    <h1>Add Project</h1>
    <hr>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('failed'))
        <div class="alert alert-danger text-white" style="background-color: rgb(253, 105, 105);">
            {{ session('failed') }}
        </div>
    @endif
    <form action="{{ route('dashboard.add_name_project')}}" method="POST">
        @csrf
        <div class="mb-3">
            <div class="input-group mb-3" style="width: 50%">
                <input type="text" class="form-control" placeholder="Name Project" aria-label="Name Project" aria-describedby="button-addon2" name="name_project" value="{{ session('name_project') ?? ''}}">
                <button class="btn btn-outline-secondary" {{ session('name_project') ? 'disabled' : ''}} type="submit">Save</button>
            </div>
        </div>
    </form>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Input Manual</button>
          <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Import File</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <form action="{{ route('dashboard.process_add_project', 'type=url')}}" method="POST" id="urlForm">
                @csrf
                <div class="mb-3 mt-3">
                    <label for="exampleFormControlInput1" class="form-label">Name Endpoint/URL</label>
                    <input type="text" required class="form-control" id="exampleFormControlInput1" placeholder="Name Endpoint/URL" style="width: 50%" name="name_url">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Endpoint/URL</label>
                    <div class="row">
                        <div class="col-2">
                            <select class="form-select"  required aria-label="Default select example" name="method" id="methodSelect">
                                <option selected>Method</option>
                                <option value="GET">GET</option>
                                <option value="POST">POST</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="http://tester.com/index.php?=1" name="url" required>
                            <label for="" class="mt-3">Post Data</label>
                            <input type="text" class="form-control" id="post_data" placeholder="search=test&id=1" name="post_data" disabled>
                        </div>
                    </div>
                </div>
                <div class="mb-3 mt-3">
                    <label for="exampleFormControlInput1" class="form-label">Headers</label>
                    <textarea name="header" style="width: 50%;" id="" cols="30" rows="5" class="form-control"></textarea>
                </div>
                <button class="btn btn-secondary" type="submit" id="inputGroupFileAddon04">
                    Add URL
                </button>
            </form>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <form action="{{ route('dashboard.process_add_project', 'type=import')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="exampleFormControlInput1" class="form-label mt-3">Import File</label>
                <div class="input-group" style="width: 50%">
                    <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="file_postman" >
                    <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04">
                        <img src="{{ url('/assets/images/logos/postman.svg')}}" width="20" alt="" />
                        &nbsp;
                        Import Postman
                    </button>
                </div>
            </form>
        </div>
    </div>
    @if(session('info_url'))
    <hr>    
        {{-- {{ json_encode(session('info_url'))}} --}}
        <div class="card w-100">
            <div class="card-body p-4">
                <a href="{{ route('dashboard.reset_project') }}" class="btn btn-outline-info float-end mb-3"><i class="ti ti-refresh"></i>&nbsp;Reset</a>
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
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Action</h6>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @php 
                        $no = 0;
                        $items = session('info_url');
                        // dd($items)
                    @endphp
                    @foreach ($items as $item)
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
                            <td class="border-bottom-0">
                                <a href="{{ route('dashboard.delete_project', $item["id"])}}">
                                    <i class="ti ti-trash text-danger" style="font-size: 20px;"></i>
                                </a>
                            </td>
                        </tr>   
                    @endforeach               
                </tbody>
                </table>
              </div>
            </div>
        </div>
        <div class="float-end">
            <a href="{{ route('dashboard.project_detail') }}" class="btn btn-primary">Continue <i class="ti ti-caret-right"></i></a>
        </div>
    @endif
@endsection
@section('js')
<script>
    // Mendapatkan elemen select dan input post_data
    var methodSelect = document.getElementById('methodSelect');
    var postDataInput = document.getElementById('post_data');

    // Menambahkan event listener untuk perubahan pada elemen select
    methodSelect.addEventListener('change', function () {
        // Mengatur status disable pada input post_data berdasarkan nilai yang dipilih pada elemen select
        postDataInput.disabled = (methodSelect.value !== 'POST');
    });

    // Memastikan bahwa status disable pada input post_data sesuai dengan nilai awal elemen select
    postDataInput.disabled = (methodSelect.value !== 'POST');
</script>
    
@endsection