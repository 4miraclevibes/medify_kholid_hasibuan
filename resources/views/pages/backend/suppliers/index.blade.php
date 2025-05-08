@extends('layouts.backend.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">Create</button>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Table Supplier</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Name</th>
            <th class="text-white">Email</th>
            <th class="text-white">Phone</th>
            <th class="text-white">Address</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($items as $item)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->phone }}</td>
            <td>{{ $item->address }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- / Content -->
@endsection