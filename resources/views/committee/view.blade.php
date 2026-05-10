@extends('layouts.app')

@section('styles')
<style>
    .tab-card { background: #fff; border: 1px solid #e5e5e5; border-radius: 10px; padding: 20px; }
    .file-card { border: 1px solid #e5e5e5; border-radius: 8px; overflow: hidden; transition: box-shadow .2s; }
    .file-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.1); }
    .nav-tabs .nav-link { font-size: 13px; font-weight: 600; color: #555; }
    .nav-tabs .nav-link.active { color: #1a3a5c; border-bottom: 2px solid #1a3a5c; }
    .record-title { font-size: 13px; font-weight: 700; margin-bottom: 2px; }
    .record-desc { font-size: 12px; color: #777; }
    .file-icon { font-size: 40px; color: #1a3a5c; }
    .empty-state { text-align: center; padding: 40px; color: #aaa; }
    .empty-state i { font-size: 48px; margin-bottom: 12px; }
</style>
@endsection

@section('content')
<div class="container-fluid p-4">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-0">
                <i class="fa-solid {{ $committee['icon'] }} me-2" style="color:#1a3a5c;"></i>
                {{ $committee['name'] }}
            </h2>
            <span class="text-muted small">Chairperson: <strong>{{ $committee['chair'] }}</strong></span>
        </div>
        <a href="{{ route('committee.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @php
    $tabs = [
        'photo'       => ['label' => 'Photos',       'icon' => 'fa-image',            'accept' => 'image/*',       'kind' => 'image'],
        'video'       => ['label' => 'Videos',       'icon' => 'fa-video',            'accept' => 'video/*',       'kind' => 'video'],
        'activity'    => ['label' => 'Activities',   'icon' => 'fa-calendar-check',   'accept' => '.pdf,.doc,.docx,.jpg,.png', 'kind' => 'file'],
        'accomplishment' => ['label' => 'Accomplishments', 'icon' => 'fa-trophy',     'accept' => '.pdf,.doc,.docx,.jpg,.png', 'kind' => 'file'],
        'report'      => ['label' => 'Reports',      'icon' => 'fa-file-lines',       'accept' => '.pdf,.doc,.docx,.xls,.xlsx', 'kind' => 'file'],
        'attendance'  => ['label' => 'Attendance',   'icon' => 'fa-clipboard-user',   'accept' => '.pdf,.doc,.docx,.xls,.xlsx,.jpg,.png', 'kind' => 'file'],
        'inventory'   => ['label' => 'Inventory',    'icon' => 'fa-boxes-stacked',    'accept' => '.pdf,.doc,.docx,.xls,.xlsx', 'kind' => 'file'],
        'partnership' => ['label' => 'Partnerships', 'icon' => 'fa-handshake',        'accept' => '.pdf,.doc,.docx,.jpg,.png', 'kind' => 'file'],
        'certificate' => ['label' => 'Certificates', 'icon' => 'fa-certificate',      'accept' => '.pdf,.jpg,.png', 'kind' => 'file'],
        'other'       => ['label' => 'Others',       'icon' => 'fa-folder-open',      'accept' => '*',             'kind' => 'file'],
    ];
    @endphp

    {{-- Tabs Nav --}}
    <ul class="nav nav-tabs mb-0 flex-nowrap overflow-auto" style="scrollbar-width:none;">
        @foreach($tabs as $type => $info)
        <li class="nav-item flex-shrink-0">
            <a class="nav-link {{ $loop->first ? 'active' : '' }}"
               data-bs-toggle="tab" href="#tab-{{ $type }}">
                <i class="fa-solid {{ $info['icon'] }} me-1"></i>
                {{ $info['label'] }}
                @php $count = $records->get($type, collect())->count(); @endphp
                @if($count > 0)
                <span class="badge bg-primary ms-1">{{ $count }}</span>
                @endif
            </a>
        </li>
        @endforeach
    </ul>

    {{-- Tab Content --}}
    <div class="tab-content tab-card" style="border-top:none; border-radius: 0 0 10px 10px;">
        @foreach($tabs as $type => $info)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ $type }}">

            {{-- Tab Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3 pt-2">
                <h6 class="fw-bold mb-0">
                    <i class="fa-solid {{ $info['icon'] }} me-1 text-primary"></i>
                    {{ $info['label'] }}
                </h6>
                @hasanyrole('admin|secretary')
                <button class="btn btn-success btn-sm"
                    onclick="openUpload('{{ $type }}', '{{ $info['label'] }}', '{{ $info['accept'] }}')"
                    data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="fa-solid fa-upload me-1"></i> Upload
                </button>
                @endhasanyrole
            </div>

            {{-- Records Grid --}}
            @php $items = $records->get($type, collect()); @endphp
            @if($items->isEmpty())
            <div class="empty-state">
                <i class="fa-solid {{ $info['icon'] }} d-block"></i>
                No {{ strtolower($info['label']) }} uploaded yet.
            </div>
            @else
                @if($info['kind'] === 'image')
                {{-- Image Grid --}}
                <div class="row g-3">
                    @foreach($items as $item)
                    <div class="col-6 col-md-3">
                        <div class="file-card">
                            <img src="{{ asset('storage/' . $item->file_path) }}"
                                 style="height:180px; width:100%; object-fit:cover; cursor:pointer; background:#f5f5f5;"
                                 onclick="openLightbox('{{ asset('storage/' . $item->file_path) }}', '{{ addslashes($item->title) }}')">
                            <div class="p-2">
                                <div class="record-title">{{ $item->title }}</div>
                                @if($item->description)
                                <div class="record-desc">{{ $item->description }}</div>
                                @endif
                                @hasanyrole('admin|secretary')
                                <div class="d-flex gap-1 mt-2">
                                    <button class="btn btn-warning btn-sm flex-fill"
                                        onclick="openEdit({{ $item->id }}, '{{ addslashes($item->title) }}', '{{ addslashes($item->description) }}', '{{ $type }}')">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="{{ route('committee.record.delete', [$slug, $item->id]) }}" method="POST" class="flex-fill">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm w-100"
                                            onclick="return confirm('Delete this?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                @endhasanyrole
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @elseif($info['kind'] === 'video')
                {{-- Video Grid --}}
                <div class="row g-3">
                    @foreach($items as $item)
                    <div class="col-md-4">
                        <div class="file-card p-2">
                            <video src="{{ asset('storage/' . $item->file_path) }}"
                                   controls style="width:100%; border-radius:6px; max-height:200px;"></video>
                            <div class="mt-2">
                                <div class="record-title">{{ $item->title }}</div>
                                @if($item->description)
                                <div class="record-desc">{{ $item->description }}</div>
                                @endif
                                @hasanyrole('admin|secretary')
                                <div class="d-flex gap-1 mt-2">
                                    <button class="btn btn-warning btn-sm flex-fill"
                                        onclick="openEdit({{ $item->id }}, '{{ addslashes($item->title) }}', '{{ addslashes($item->description) }}', '{{ $type }}')">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </button>
                                    <form action="{{ route('committee.record.delete', [$slug, $item->id]) }}" method="POST" class="flex-fill">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm w-100"
                                            onclick="return confirm('Delete this video?')">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                                @endhasanyrole
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @else
                {{-- File/Document List --}}
                <div class="row g-2">
                    @foreach($items as $item)
                    @php
                        $ext = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));
                        $fileIcon = match(true) {
                            in_array($ext, ['pdf'])           => ['fa-file-pdf',   'text-danger'],
                            in_array($ext, ['doc','docx'])    => ['fa-file-word',  'text-primary'],
                            in_array($ext, ['xls','xlsx'])    => ['fa-file-excel', 'text-success'],
                            in_array($ext, ['jpg','jpeg','png','gif']) => ['fa-file-image', 'text-warning'],
                            default                           => ['fa-file',       'text-secondary'],
                        };
                    @endphp
                    <div class="col-md-6">
                        <div class="file-card p-3 d-flex align-items-center gap-3">
                            <i class="fa-solid {{ $fileIcon[0] }} {{ $fileIcon[1] }}" style="font-size:32px; flex-shrink:0;"></i>
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="record-title text-truncate">{{ $item->title }}</div>
                                @if($item->description)
                                <div class="record-desc text-truncate">{{ $item->description }}</div>
                                @endif
                                <div class="record-desc">{{ strtoupper($ext) }} &bull; {{ $item->created_at->format('M d, Y') }}</div>
                            </div>
                            <div class="d-flex flex-column gap-1 flex-shrink-0">
                                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                                   class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ asset('storage/' . $item->file_path) }}" download
                                   class="btn btn-secondary btn-sm">
                                    <i class="fa-solid fa-download"></i>
                                </a>
                                @hasanyrole('admin|secretary')
                                <button class="btn btn-warning btn-sm"
                                    onclick="openEdit({{ $item->id }}, '{{ addslashes($item->title) }}', '{{ addslashes($item->description) }}', '{{ $type }}')">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <form action="{{ route('committee.record.delete', [$slug, $item->id]) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-100"
                                        onclick="return confirm('Delete this file?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                                @endhasanyrole
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            @endif
        </div>
        @endforeach
    </div>
</div>

{{-- Upload Modal --}}
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalTitle">Upload</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('committee.upload', $slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" id="uploadType">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">File <span class="text-danger">*</span></label>
                        <input type="file" name="file" id="uploadFileInput" class="form-control" required>
                        <div class="form-text" id="uploadFileHint"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Optional"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-upload me-1"></i> Upload
                    </button>
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
                <h5 class="modal-title">Edit Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" name="title" id="editTitle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Replace File <span class="text-muted">(optional)</span></label>
                        <input type="file" name="file" id="editFileInput" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" id="editDescription" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Lightbox --}}
<div class="modal fade" id="lightboxModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-dark border-0">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title text-white" id="lightboxTitle"></h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-2">
                <img id="lightboxImage" src="" class="img-fluid rounded" style="max-height:80vh; object-fit:contain;">
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Open upload modal and set type/accept
    function openUpload(type, label, accept) {
        document.getElementById('uploadType').value        = type;
        document.getElementById('uploadModalTitle').textContent = 'Upload ' + label;
        document.getElementById('uploadFileInput').accept  = accept;
        document.getElementById('uploadFileHint').textContent  = 'Accepted: ' + accept;
    }

    // Open edit modal
    function openEdit(id, title, description, type) {
        document.getElementById('editTitle').value       = title;
        document.getElementById('editDescription').value = description;
        document.getElementById('editForm').action       = '/committee/{{ $slug }}/records/' + id;

        // Set accept based on type
        const accepts = {
            photo: 'image/*', video: 'video/*',
            report: '.pdf,.doc,.docx,.xls,.xlsx',
            attendance: '.pdf,.doc,.docx,.xls,.xlsx,.jpg,.png',
            certificate: '.pdf,.jpg,.png',
        };
        document.getElementById('editFileInput').accept = accepts[type] || '*';

        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    // Open lightbox
    function openLightbox(src, title) {
        document.getElementById('lightboxImage').src         = src;
        document.getElementById('lightboxTitle').textContent = title;
        new bootstrap.Modal(document.getElementById('lightboxModal')).show();
    }
</script>
@endsection
