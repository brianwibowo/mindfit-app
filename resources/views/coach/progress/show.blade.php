<x-app-layout>
    <x-slot name="header">Detail Progress Klien</x-slot>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Detail Log: {{ $log->client->name }}</div>
                    <a href="{{ route('coach.progress.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ $log->date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tipe Log</th>
                                    <td><span class="badge badge-info">{{ ucfirst($log->type) }}</span></td>
                                </tr>
                                <tr>
                                    <th>Berat Badan</th>
                                    <td>{{ $log->weight ? $log->weight . ' Kg' : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Lingkar Pinggang</th>
                                    <td>{{ $log->waist ? $log->waist . ' cm' : '-' }}</td>
                                </tr>
                            </table>

                            <hr>
                            <h6>Catatan Klien:</h6>
                            <div class="p-3 bg-light rounded mb-3">
                                <i>"{{ $log->description ?: 'Tidak ada catatan.' }}"</i>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            @if($log->photo)
                                <h6>Foto Fisik</h6>
                                <img src="{{ asset('storage/' . $log->photo) }}" class="img-fluid rounded border mb-2"
                                    style="max-height: 300px;">
                                <br>
                                <a href="{{ asset('storage/' . $log->photo) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-search-plus"></i> Zoom
                                </a>
                            @else
                                <div class="alert alert-light mt-4">
                                    <i class="fas fa-camera-retro fa-2x mb-3 text-muted"></i>
                                    <p class="text-muted">Tidak ada foto.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    {{-- FEEDBACK SECTION --}}
                    <div class="mt-4">
                        <h5 class="text-primary mb-3"><i class="fas fa-comment-dots"></i> Feedback Coach</h5>

                        {{-- DISPLAY MODE: Show if feedback exists --}}
                        @if($log->coach_note)
                            <div id="feedback-display">
                                <div class="alert alert-success d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Feedback Tersimpan:</strong>
                                        <p class="mb-0 mt-2" style="white-space: pre-line;">"{{ $log->coach_note }}"</p>
                                    </div>
                                    <button class="btn btn-sm btn-outline-success" onclick="toggleEditFeedback()">
                                        <i class="fas fa-edit"></i> Edit Feedback
                                    </button>
                                </div>
                            </div>
                        @else
                            <div id="feedback-empty" class="alert alert-warning">Belum ada feedback. Silakan isi form di
                                bawah.</div>
                        @endif

                        {{-- EDIT FORM: Hidden by default if feedback exists --}}
                        <div id="feedback-form" style="{{ $log->coach_note ? 'display: none;' : '' }}">
                            <div class="card border border-primary">
                                <div class="card-body">
                                    <form action="{{ route('coach.progress.update', $log->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label class="fw-bold">Tulis Catatan / Masukan Anda:</label>
                                            <textarea name="coach_note" class="form-control" rows="4" required
                                                placeholder="Berikan semangat atau evaluasi...">{{ old('coach_note', $log->coach_note) }}</textarea>
                                        </div>
                                        <div class="form-group text-end d-flex justify-content-end gap-2">
                                            @if($log->coach_note)
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="toggleEditFeedback()">Batal</button>
                                            @endif
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Simpan Feedback
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleEditFeedback() {
                var displayDiv = document.getElementById('feedback-display');
                var formDiv = document.getElementById('feedback-form');
                var emptyDiv = document.getElementById('feedback-empty');

                if (displayDiv && displayDiv.style.display === 'none') {
                    displayDiv.style.display = 'block';
                    formDiv.style.display = 'none';
                } else {
                    if (displayDiv) displayDiv.style.display = 'none';
                    if (emptyDiv) emptyDiv.style.display = 'none';
                    formDiv.style.display = 'block';
                }
            }
        </script>
    @endpush
</x-app-layout>