@extends('layouts.app')

@section('title', 'Edit RS')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('rs.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors gap-1">
            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-2xl font-bold text-slate-900 mt-2 tracking-tight">Perbarui Data RS</h1>
        <p class="text-sm text-slate-500">Mengubah Identitas Rumah Sakit dengan Kode Rs: <span class="font-semibold text-blue-600">{{ $pasien->no_bpjs }}</span></p>
    </div>

    <!-- Alert Container -->
    <div id="alertBox" class="hidden mb-6 p-4 rounded-xl border text-sm font-medium"></div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form id="formEdit" class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- No BPJS (Readonly / Disabled secara profesional) -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-600 mb-1.5 opacity-70">Kode RS</label>
                    <input type="number" value="{{ $rs->kode_rs }}" class="w-full px-3.5 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-400 font-medium text-sm cursor-not-allowed" disabled>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap RS</label>
                    <input type="text" id="nama_rs" value="{{ $rs->nama_rs }}" class="w-full px-3.5 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" required>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Tempat Operasi</label>
                    <textarea id="alamat_rs" rows="3" class="w-full px-3.5 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" required>{{ $pasien->address }}</textarea>
                </div>

                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status Kepesertaan</label>
                    <select id="status_rs" class="w-full px-3.5 py-2 border border-slate-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" required>
                        <option value="aktif" {{ $pasien->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak aktif" {{ $pasien->status == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('rs.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-colors">Batal</a>
                <button type="submit" class="px-4 py-2 rounded-lg text-sm font-semibold text-white bg-amber-600 hover:bg-amber-700 shadow-sm shadow-amber-100 transition-colors">Perbarui Data</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('formEdit').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const alertBox = document.getElementById('alertBox');
        alertBox.className = 'hidden'; 

        const formData = {
            username: document.getElementById('username').value,
            born: document.getElementById('born').value,
            status: document.getElementById('status').value,
            address: document.getElementById('address').value,
        };

        fetch('/api/bpjs/{{ $pasien->no_bpjs }}', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(formData)
        })
        .then(async res => {
            const data = await res.json();
            if (res.status === 200) {
                alertBox.className = 'mb-6 p-4 rounded-xl border text-sm font-medium bg-emerald-50 text-emerald-700 border-emerald-200';
                alertBox.innerText = data.message;
                setTimeout(() => window.location.href = "{{ route('pasien.index') }}", 1500);
            } else {
                alertBox.className = 'mb-6 p-4 rounded-xl border text-sm font-medium bg-rose-50 text-rose-700 border-rose-200';
                alertBox.innerText = data.message || 'Gagal mengubah rincian data.';
            }
        })
        .catch(() => {
            alertBox.className = 'mb-6 p-4 rounded-xl border text-sm font-medium bg-rose-50 text-rose-700 border-rose-200';
            alertBox.innerText = 'Terjadi gangguan koneksi internet.';
        });
    });
</script>
@endpush
