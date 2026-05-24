@extends('layouts.app')

@section('title', 'Tambah RS')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('rs.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors gap-1">
            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-2xl font-bold text-slate-900 mt-2 tracking-tight">Tambah RS Kode</h1>
        <p class="text-sm text-slate-500">Pastikan kode RS terdaftar sesuai berkas identitas resmi.</p>
    </div>

    <!-- Alert Container -->
    <div id="alertBox" class="hidden mb-6 p-4 rounded-xl border text-sm font-medium"></div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form id="formTambah" class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kode RS</label>
                    <input type="number" id="kode_rs" class="w-full px-3.5 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder:text-slate-400 text-sm" placeholder="Contoh: 0001234567890" required>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap RS</label>
                    <input type="text" id="nama_rs" class="w-full px-3.5 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder:text-slate-400 text-sm" placeholder="Masukkan nama sesuai KTP" required>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Tempat Operasu</label>
                    <textarea id="alamat_rs" rows="3" class="w-full px-3.5 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder:text-slate-400 text-sm" placeholder="Nama jalan, nomor rumah, RT/RW, kecamatan" required></textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status Operasi</label>
                    <select id="status_rs" class="w-full px-3.5 py-2 border border-slate-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" required>
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>
                    </select>
                </div>

            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('rs.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-colors">Batal</a>
                <button type="submit" class="px-4 py-2 rounded-lg text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 shadow-sm shadow-blue-100 transition-colors">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('formTambah').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const alertBox = document.getElementById('alertBox');
        alertBox.className = 'hidden'; // Reset alert

        const formData = {
            no_bpjs: document.getElementById('no_bpjs').value,
            username: document.getElementById('username').value,
            born: document.getElementById('born').value,
            status: document.getElementById('status').value,
            address: document.getElementById('address').value,
        };

        fetch('/api/bpjs', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(formData)
        })
        .then(async res => {
            const data = await res.json();
            if (res.status === 201) {
                alertBox.className = 'mb-6 p-4 rounded-xl border text-sm font-medium bg-emerald-50 text-emerald-700 border-emerald-200';
                alertBox.innerText = data.message;
                setTimeout(() => window.location.href = "{{ route('pasien.index') }}", 1500);
            } else {
                alertBox.className = 'mb-6 p-4 rounded-xl border text-sm font-medium bg-rose-50 text-rose-700 border-rose-200';
                alertBox.innerText = data.message || 'Gagal validasi data form.';
            }
        })
        .catch(() => {
            alertBox.className = 'mb-6 p-4 rounded-xl border text-sm font-medium bg-rose-50 text-rose-700 border-rose-200';
            alertBox.innerText = 'Terjadi error sistem pada server.';
        });
    });
</script>
@endpush
