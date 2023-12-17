@extends('layouts.dashboard_layout')
@section('title', 'Detail Launch Project')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<style>
  .scrollspy-code {
    max-height: 500px; /* Atur tinggi maksimum */
    overflow-y: auto; /* Tambahkan scrollbar jika kontennya lebih panjang dari tinggi maksimum */
    position: sticky;
    top: 0;
    z-index: 1000;
}
</style>
@endsection
@section('content')
    <div class="row">
      <div class="col">
        <h1 class="float-left text-grey">{{ $project->is_active ? $project->name_project : 'Project Deleted!' }}</h1>
      </div>
      <div class="col">
        @if($project->is_active)
          <a href="{{ route('dashboard.project_launch_delete', $project->id )}}" class="btn btn-danger float-end" style="background-color: rgb(255, 57, 57)"><i class="ti ti-trash text-white" style="font-size: 20px;"></i> Delete Project</a>
        @else 
          <a href="#" style="color: rgb(255, 57, 57)"><i class="ti ti-trash text-white">Inactive</a>
        @endif
      </div>
    </div>
    <hr>
    @if($project->is_active)
    <div class="card w-100">
      <div class="card-body p-4">
        <div class="mb-4">
          <div class="row">
            <div class="col">
              <h5 class="card-title fw-semibold float-left">Recent Endpoint/URL</h5>
            </div>
            <div class="col">
              <a href="" class="btn btn-outline-primary float-end"><i class="ti ti-refresh"></i> Refresh</a>
            </div>
          </div>
        </div>
        <ul class="timeline-widget mb-0 position-relative mb-n5">
          @foreach ($arrayItem as $item)
          <li class="timeline-item d-flex position-relative overflow-hidden">
            @php
                $method = strtolower($item["items"]["method"]);
                $badgeClass = '';

                if ($method == 'get') {
                    $badgeClass = 'text-success';
                } elseif ($method == 'post') {
                    $badgeClass = 'text-warning';
                } elseif ($method == 'delete') {
                    $badgeClass = 'text-danger';
                } elseif ($method == 'options') {
                    $badgeClass = 'text-info';
                } else {
                    // Default class jika metode tidak dikenali
                    $badgeClass = 'bg-secondary';
                }
            @endphp
            <div class="timeline-time {{$badgeClass}} flex-shrink-0 text-end">{{ $item["items"]["method"]}}</div>
            <div class="timeline-badge-wrap d-flex flex-column align-items-center">
              @php
                $status = strtolower($item["status"]);
                $colorClass = '';

                if ($status == 'terminated') {
                    $colorClass = 'border-success';
                } else {
                    // Default class jika metode tidak dikenali
                    $colorClass = 'animate__animated animate__fadeIn animate__infinite border-info';
                }
              @endphp
              <span class="{{ $colorClass }} timeline-badge border-2 border flex-shrink-0 my-8"></span>
              <span class="timeline-badge-border d-block flex-shrink-0"></span>
            </div>
            <div class="timeline-desc fs-3 text-dark mt-n1 fw-semibold">
              <h5>{{ $item["items"]["name_url"]}}</h5>
              <p>{{ $item["items"]["url"]}}</p>
              <span style="color: grey">TaskID : {{ $item["items"]["taskID"]}}&nbsp; <a class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse" href="#collapse-{{ $item["items"]["taskID"]}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                Log Scan
              </a></span>
              <div class="collapse" id="collapse-{{ $item["items"]["taskID"]}}">
                <div class="card card-body">
                  <p>Scan Status : 
                    @if ($item["status"] == "terminated")
                      <span class="text-danger">{{ $item["status"] }}</span>
                    @elseif($item["status"] == "running")
                      <span class="text-success">{{ $item["status"] }}</span>
                    @else 
                      <span>{{ $item["status"] }}</span>
                    @endif
                  </p>
                  <code style="background-color: rgb(19, 19, 19); padding: 2px 4px; border-radius: 3px; color: rgb(247, 247, 247); padding: 10px;" class="scrollspy-code">
                    <table>
                      <tbody>
                        @foreach ($item["log"] as $items)
                            @php
                              $color = "";

                              if($items["level"] == "CRITICAL") {
                                $color = "red";
                              } else if ($items["level"] == "WARNING") {
                                $color = "yellow";
                              } else {
                                $color = "rgb(81, 255, 0)";
                              }
                            @endphp
                            <tr>
                              <td style="color: aqua">[{{ $items["time"] }}]</td>
                              <td style="color: {{ $color }};">[{{ $items["level"] }}]</td>
                              <td>{{ $items["message"] }}</td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </code>
                </div>
              </div>
            </div>
          </li>
          @endforeach
          <br>
        </ul>
      </div>
    </div>
    @endif
@endsection