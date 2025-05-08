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
    <div class="card-header">
        <form method="GET" action="{{ route('master-items.index') }}" class="d-flex align-items-center">
            <div class="form-group me-3">
                <label for="min_price" class="form-label">Harga Min</label>
                <input type="number" class="form-control form-control-sm" id="min_price" name="min_price" value="{{ request('min_price') }}" placeholder="Min Harga" style="max-width: 150px;">
            </div>
            <div class="form-group me-3">
                <label for="max_price" class="form-label">Harga Max</label>
                <input type="number" class="form-control form-control-sm" id="max_price" name="max_price" value="{{ request('max_price') }}" placeholder="Max Harga" style="max-width: 150px;">
            </div>
            <button type="submit" class="btn btn-primary btn-sm mt-4">Filter</button>
        </form>
    </div>
    <h5 class="card-header">Tabel Master Item</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead class="table-dark text-white">
          <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Kode Category</th>
            <th>Item Gambar</th>
            <th>Nama</th>
            <th>Harga Beli</th>
            <th>Laba</th>
            <th>Supplier</th>
            {{-- <th>Jenis</th> --}}
            <th>Kategori</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($items as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->kode }}</td>
            <td>{{ $item->category->code }}</td>
            <td><a href="{{ Storage::url($item->image) }}" class="btn btn-sm btn-primary {{ $item->image == null ? 'disabled' : '' }}" target="_blank">Gambar</a></td>
            <td>{{ $item->nama }}</td>
            <td>{{ number_format($item->harga_beli) }}</td>
            <td>{{ number_format($item->laba) }} % : {{ number_format($item->laba / 100 * $item->harga_beli) }}</td>
            <td>{{ $item->supplier->name }}</td>
            {{-- <td>{{ $item->jenis }}</td> --}}
            <td>{{ $item->category->name ?? '-' }}</td>
            <td>
                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#showModal{{ $item->id }}">Show</button>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">Edit</button>

                <!-- Form untuk Delete -->
                <form action="{{ route('master-items.destroy', $item->id) }}" method="POST" style="display:inline;">
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
    <form action="{{ route('master-items.store') }}" method="POST" class="modal-content" enctype="multipart/form-data">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Tambah Item</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label>Kode</label>
          <input type="text" class="form-control" name="kode" required>
        </div>
        <div class="mb-3">
          <label>Nama</label>
          <input type="text" class="form-control" name="nama" required>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Gambar</label>
            <input type="file" class="form-control" id="file" name="image" required>
        </div>
        <div class="mb-3">
          <label>Harga Beli</label>
          <input type="number" class="form-control" name="harga_beli">
        </div>
        <div class="mb-3">
          <label>Laba (persen) </label>
          <input type="number" class="form-control" name="laba">
        </div>
        <div class="mb-3">
            <label>Supplier</label>
            <select class="form-control" name="supplier_id">
              @foreach ($suppliers as $sup)
                <option value="{{ $sup->id }}">{{ $sup->name }}</option>
              @endforeach
            </select>
          </div>
        <div class="mb-3">
          <label>Jenis</label>
          <input type="text" class="form-control" name="jenis">
        </div>
        <div class="mb-3">
          <label>Kategori</label>
          <select class="form-control" name="category_id">
            @foreach ($categories as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
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
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Item</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>Kode:</strong> {{ $item->kode }}</p>
        <p><strong>Nama:</strong> {{ $item->nama }}</p>
        <p><strong>Harga Beli:</strong> {{ number_format($item->harga_beli) }}</p>
        <p><strong>Laba:</strong> {{ number_format($item->laba) }} % {{ number_format($item->laba / 100 * $item->harga_beli) }} </p>
        <p><strong>Supplier:</strong> {{ $item->supplier->name }} |  {{ $item->supplier->phone }} | {{ $item->supplier->email }} | {{ $item->supplier->address }}</p>
        <p><strong>Jenis:</strong> {{ $item->jenis }}</p>
        <p><strong>Kategori:</strong> {{ $item->category->name ?? '-' }}</p>
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
    <form action="{{ route('master-items.update', $item->id) }}" method="POST" class="modal-content" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit Item</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label>Kode</label>
          <input type="text" class="form-control" name="kode" value="{{ $item->kode }}" required>
        </div>
        <div class="mb-3">
          <label>Nama</label>
          <input type="text" class="form-control" name="nama" value="{{ $item->nama }}" required>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Gambar</label>
            <input type="file" class="form-control" id="file" name="image">
        </div>
        <div class="mb-3">
          <label>Harga Beli</label>
          <input type="number" class="form-control" name="harga_beli" value="{{ $item->harga_beli }}">
        </div>
        <div class="mb-3">
          <label>Laba</label>
          <input type="number" class="form-control" name="laba" value="{{ $item->laba }}">
        </div>
        <div class="mb-3">
            <label>Supplier</label>
            <select class="form-control" name="supplier_id">
              @foreach ($suppliers as $sup)
                <option value="{{ $sup->id }}" {{ $sup->id == $item->supplier_id ? 'selected' : '' }}>
                  {{ $sup->name }}
                </option>
              @endforeach
            </select>
          </div>
        <div class="mb-3">
          <label>Jenis</label>
          <input type="text" class="form-control" name="jenis" value="{{ $item->jenis }}">
        </div>
        <div class="mb-3">
          <label>Kategori</label>
          <select class="form-control" name="category_id">
            @foreach ($categories as $cat)
              <option value="{{ $cat->id }}" {{ $cat->id == $item->category_id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
        </div>
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
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
