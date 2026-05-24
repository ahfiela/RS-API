@extends('layouts.app')

@section('title', 'Daftar RS')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Dashboard RS</h1>
        <p class="mt-1 text-sm text-slate-500">Kelola rincian data, status operasi, dan validasi kode RS.</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('rs.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-semibold rounded-lg text-white bg-blue-600 hover:bg-blue-700 shadow-sm shadow-blue-100 transition-all gap-2">
            <i class="fa-solid fa-plus text-xs"></i> Tambah RS Baru
        </a>
    </div>
</div>

<!-- Table Card -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">No. BPJS</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Nama Pasien</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse($pasiens as $p)
                <tr id="row-{{ $p->no_bpjs }}" class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                        {{ $p->no_bpjs }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-slate-900">{{ $p->username }}</div>
                        <div class="text-xs text-slate-400 mt-0.5"><i class="fa-regular fa-calendar text-xxs mr-1"></i> {{ \Carbon\Carbon::parse($p->born)->translatedFormat('d F Y') }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate">
                        {{ $p->address }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($p->status == 'aktif')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">
                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Tidak Aktif
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                        <div class="flex items-center justify-end gap-2">
                            <!-- Tombol Edit dengan Teks -->
                            <a href="{{ route('pasien.edit', $p->no_bpjs) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-lg border border-amber-200 transition-all" title="Edit Data">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Edit</span>
                            </a>
                            
                            <!-- Tombol Hapus dengan Teks -->
                            <button onclick="hapusPasien('{{ $p->no_bpjs }}')" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-lg border border-rose-200 transition-all" title="Hapus Data">
                                <i class="fa-solid fa-trash-can"></i>
                                <span>Hapus</span>
                            </button>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-400">
                        <i class="fa-regular fa-folder-open text-3xl text-slate-300 mb-2 block"></i>
                        Belum ada data pasien BPJS terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function hapusPasien(noBpjs) {
        if (confirm('Apakah Anda yakin ingin menghapus permanen data pasien ini?')) {
            fetch(`/api/bpjs/${noBpjs}`, {
                method: 'DELETE',
                headers: { 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                const targetRow = document.getElementById(`row-${noBpjs}`);
                if (targetRow) targetRow.remove();
            })
            .catch(() => alert('Terjadi kesalahan jaringan atau server.'));
        }
    }
</script>
@endpush
