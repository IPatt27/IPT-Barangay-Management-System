@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-0">{{ $committee['name'] }}</h2>
            <span class="text-muted">{{ $committee['chair'] }}</span>
        </div>
        <a href="{{ route('committee.index') }}" class="btn btn-primary">← Back</a>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-4" id="committeeTabs">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#photos">Photos</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#videos">Videos</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#activities">Activities</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#accomplishments">Accomplishments</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#reports">Reports</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#attendance">Attendance</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#others">Others</a></li>
    </ul>

    {{-- Tab Content --}}
    <div class="tab-content">

        {{-- Photos Tab --}}
        <div class="tab-pane fade show active" id="photos">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Photos</h5>
                @hasanyrole('admin|secretary')
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal" onclick="setType('photo')">+ Upload Photo</button>
                @endhasanyrole
            </div>
            <div class="row g-3">
                @forelse($records->get('photo', collect()) as $photo)
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset('storage/' . $photo->file_path) }}"
                             class="card-img-top"
                             style="height: 220px; object-fit: contain; background: #f8f8f8; cursor: pointer;"
                             data-image="{{ asset('storage/' . $photo->file_path) }}"
                             data-title="{{ $photo->title }}"
                             onclick="openLightbox(this)">
                        <div class="card-body p-2">
                            <p class="small mb-0 fw-bold">{{ $photo->title }}</p>
                            <p class="small text-muted mb-0">{{ $photo->description }}</p>

                            <div class="d-flex gap-2 mt-2">
                                @hasanyrole('admin|secretary')
                                <button class="btn btn-sm btn-action-edit btn-warning w-50"
                                    data-id="{{ $photo->id }}"
                                    data-title="{{ $photo->title }}"
                                    data-description="{{ $photo->description }}"
                                    data-image="{{ asset('storage/' . $photo->file_path) }}"
                                    onclick="openEdit(this)">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <form action="{{ route('committee.record.delete', [$slug, $photo->id]) }}" method="POST" class="w-50">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-action-delete w-100"
                                        onclick="return confirm('Delete this photo?')">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </form>
                                @endhasanyrole
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted">No photos yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Other tabs - coming soon --}}
        @foreach(['videos', 'activities', 'accomplishments', 'reports', 'attendance', 'others'] as $tab)
        <div class="tab-pane fade" id="{{ $tab }}">
            <p class="text-muted mt-3">{{ ucfirst($tab) }} — coming soon.</p>
        </div>
        @endforeach

    </div>
</div>

{{-- Upload Modal --}}
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('committee.upload', $slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" id="uploadType" value="photo">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="file" class="form-control" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3 text-center">
                        <img id="editPreview" src="" class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="editTitle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Replace Photo (optional)</label>
                        <input type="file" name="file" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editDescription" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Lightbox Modal --}}
<div class="modal fade" id="lightboxModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-light border-0">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title text-dark" id="lightboxTitle"></h6>
                <button type="button" class="btn-close btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-3">
                <img id="lightboxImage" src="" class="img-fluid rounded" style="max-height: 70vh; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<script>
    function setType(type) {
        document.getElementById('uploadType').value = type;
    }

    function openEdit(btn) {
        const id          = btn.dataset.id;
        const title       = btn.dataset.title;
        const description = btn.dataset.description;
        const imageUrl    = btn.dataset.image;

        document.getElementById('editTitle').value       = title;
        document.getElementById('editDescription').value = description;
        document.getElementById('editPreview').src       = imageUrl;
        document.getElementById('editForm').action       = `/committee/{{ $slug }}/records/${id}`;

        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    function openLightbox(img) {
        document.getElementById('lightboxImage').src         = img.dataset.image;
        document.getElementById('lightboxTitle').textContent = img.dataset.title;
        new bootstrap.Modal(document.getElementById('lightboxModal')).show();
    }
</script>
@endsection