@extends('layouts.backend.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <!-- Tombol Create -->
  <div class="card">
    <div class="card-header">
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">Create</button>
    </div>
  </div>

  <!-- Tabel -->
  <div class="card mt-2">
    <h5 class="card-header">Tabel Master Category</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead class="table-dark text-white">
          <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($items as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->code }}</td>
            <td>{{ $item->name }}</td>
            <td>
                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#showModal{{ $item->id }}">Show</button>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">Edit</button>

                <!-- Form untuk Delete -->
                <form action="{{ route('categories.destroy', $item->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">Delete</button>
                </form>
              </td>

          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('categories.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Tambah Item</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label>Code</label>
          <input type="text" class="form-control" name="code" required>
        </div>
        <div class="mb-3">
          <label>Nama</label>
          <input type="text" class="form-control" name="name" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit & Show -->
@foreach ($items as $item)

<!-- Modal Show -->
<div class="modal fade" id="showModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Category</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p><strong>Code:</strong> {{ $item->code }}</p>
          <p><strong>Nama:</strong> {{ $item->name }}</p>

          <hr>
          <h6>Daftar Master Item</h6>
          @if ($item->masterItems->count())
            <ul class="list-group list-group-flush">
              @foreach ($item->masterItems as $masterItem)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  {{ $masterItem->nama }}
                  <span class="badge bg-primary">{{ number_format($masterItem->harga_beli) }}</span>
                </li>
              @endforeach
            </ul>
          @else
            <p class="text-muted">Tidak ada item dalam kategori ini.</p>
          @endif
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


<!-- Modal Edit -->
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('categories.update', $item->id) }}" method="POST" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit Item</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label>Kode</label>
          <input type="text" class="form-control" name="code" value="{{ $item->code }}" required>
        </div>
        <div class="mb-3">
          <label>Nama</label>
          <input type="text" class="form-control" name="name" value="{{ $item->name }}" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>
@endforeach

@endsection
