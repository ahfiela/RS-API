<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Validation Server</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        <div class="w-64 bg-slate-950 text-white p-6 hidden md:flex flex-col justify-between border-r border-slate-800">
            <div>
                <div class="flex items-center space-x-3 mb-8">
                    <div class="h-9 w-9 rounded-lg bg-teal-500 flex items-center justify-center font-bold text-slate-950 text-lg">H</div>
                    <div>
                        <h1 class="text-sm font-bold tracking-wider text-white uppercase">Hospival Center</h1>
                        <p class="text-[10px] text-slate-400">v1.0 (Validation Auth)</p>
                    </div>
                </div>
                <nav class="space-y-1">
                    <a href="#" class="flex items-center space-x-3 py-2.5 px-4 bg-slate-900 text-teal-400 rounded-lg font-medium transition">
                        <span>Database RS (CRUD)</span>
                    </a>
                </nav>
            </div>
            <div class="text-xs text-slate-500">Logged in as Administrator</div>
        </div>

        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white border-b border-slate-200 px-8 py-4 flex justify-between items-center shrink-0">
                <div class="flex items-center space-x-3">
                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-semibold tracking-wider text-slate-600 uppercase">Validation Gateway: Online</span>
                </div>
                <div class="text-xs font-mono bg-slate-100 text-slate-700 px-3 py-1.5 rounded-md border border-slate-200">
                    POST /api/v1/verify-hospital
                </div>
            </header>

            <main class="p-8 space-y-8">
                @if(session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm flex items-center shadow-xs">
                        <span class="mr-2 font-bold">✓</span> {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
                    
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                        <h3 class="text-base font-bold text-slate-900 mb-1">Registrasi Entitas RS</h3>
                        <p class="text-xs text-slate-500 mb-5">Tambahkan parameter kode unik untuk RS mitra.</p>
                        
                        <form action="{{ route('hospital.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">KODE RS (Harus Unik)</label>
                                <input type="text" name="kode_rs" required placeholder="Contoh: RSJKT01" class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition text-sm bg-slate-50/50">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">NAMA RUMAH SAKIT</label>
                                <input type="text" name="nama_rs" required placeholder="RS Jantung Sehat" class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition text-sm bg-slate-50/50">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">STATUS VALIDASI</label>
                                <select name="status_rs" class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition text-sm bg-white">
                                    <option value="Aktif">Aktif (Bisa Diakses External)</option>
                                    <option value="Non-Aktif">Non-Aktif (Blokir Akses)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">ALAMAT LENGKAP</label>
                                <textarea name="alamat_rs" rows="3" required placeholder="Alamat operasional resmi..." class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition text-sm bg-slate-50/50"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-medium py-2.5 rounded-xl transition text-sm cursor-pointer shadow-xs">
                                Daftarkan Rumah Sakit
                            </button>
                        </form>
                    </div>

                    <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100">
                            <h3 class="text-base font-bold text-slate-900">Entitas Terdaftar</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                        <th class="py-3 px-6">Kode RS</th>
                                        <th class="py-3 px-6">Nama Rumah Sakit</th>
                                        <th class="py-3 px-6">Status</th>
                                        <th class="py-3 px-6 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-sm">
                                    @forelse($hospitals as $rs)
                                    <tr class="hover:bg-slate-50/40 transition">
                                        <td class="py-4 px-6 font-mono font-bold text-teal-600">{{ $rs->kode_rs }}</td>
                                        <td class="py-4 px-6">
                                            <div class="font-semibold text-slate-900">{{ $rs->nama_rs }}</div>
                                            <div class="text-xs text-slate-400 max-w-xs truncate">{{ $rs->alamat_rs }}</div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $rs->status_rs == 'Aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                                {{ $rs->status_rs }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-right space-x-2">
                                            <button onclick="openEditModal({{ json_encode($rs) }})" class="text-xs font-medium text-amber-600 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 px-2.5 py-1.5 rounded-lg transition cursor-pointer">
                                                Edit
                                            </button>
                                            
                                            <form action="{{ route('hospital.destroy', $rs->id) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" onclick="return confirm('Hapus RS ini? Otomatis server external tidak bisa memvalidasi kode ini lagi.')" class="text-xs font-medium text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-2.5 py-1.5 rounded-lg transition cursor-pointer">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="py-12 text-center text-slate-400 text-sm">Belum ada rumah sakit terdaftar di server ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 border-t border-slate-100 bg-slate-50/30">
                            {{ $hospitals->links() }}
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs hidden items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl max-w-md w-full p-6 space-y-4 animate-in fade-in zoom-in-95 duration-150">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-900">Perbarui Data RS</h3>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 text-lg cursor-pointer">&times;</button>
            </div>
            
            <form id="editForm" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">KODE RS</label>
                    <input type="text" id="edit_kode" name="kode_rs" required class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">NAMA RUMAH SAKIT</label>
                    <input type="text" id="edit_nama" name="nama_rs" required class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">STATUS VALIDASI</label>
                    <select id="edit_status" name="status_rs" class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm bg-white">
                        <option value="Aktif">Aktif</option>
                        <option value="Non-Aktif">Non-Aktif</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">ALAMAT LENGKAP</label>
                    <textarea id="edit_alamat" name="alamat_rs" rows="3" required class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm"></textarea>
                </div>
                <div class="flex space-x-2 pt-2">
                    <button type="button" onclick="closeEditModal()" class="w-1/2 border border-slate-200 hover:bg-slate-50 text-slate-700 py-2 rounded-xl text-sm transition cursor-pointer">Batal</button>
                    <button type="submit" class="w-1/2 bg-teal-600 hover:bg-teal-700 text-white py-2 rounded-xl text-sm transition cursor-pointer shadow-xs">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(hospital) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            
            // Set dynamic action URL Laravel
            form.action = `/hospital/${hospital.id}`;
            
            // Fill values
            document.getElementById('edit_kode').value = hospital.kode_rs;
            document.getElementById('edit_nama').value = hospital.nama_rs;
            document.getElementById('edit_status').value = hospital.status_rs;
            document.getElementById('edit_alamat').value = hospital.alamat_rs;
            
            // Show Modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    </script>
</body>
</html>