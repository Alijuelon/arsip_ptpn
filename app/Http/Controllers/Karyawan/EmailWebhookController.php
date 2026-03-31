<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailMasuk;
use App\Models\Pengaturan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class EmailWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        return response()->json(['message' => 'HALO INI KODE BARU!']); // TAMBAHKAN BARIS INI
        // // 1. REKAM SEMUA DATA DARI POSTMAN KE LOG
        // Log::info('--- WEBHOOK MASUK ---');
        // Log::info($request->all());

        // $pengirim = $request->input('sender') ?? $request->input('from') ?? '';
        // $subjek = $request->input('subject', 'Tanpa Subjek');
        // $isiPesan = $request->input('body-plain', $request->input('text', ''));

        // $pengaturanEmail = Pengaturan::where('kunci', 'email_pusat')->first();
        // $emailPusatValid = $pengaturanEmail ? $pengaturanEmail->nilai : 'pusat@ptpn4.co.id'; 

        // // Bersihkan spasi kiri-kanan dan ubah ke huruf kecil
        // $pengirimBersih = trim(strtolower($pengirim));
        // $pusatBersih = trim(strtolower($emailPusatValid));

        // // 2. CEK KONDISI
        // if (!str_contains($pengirimBersih, $pusatBersih)) {
        //     Log::warning("Ditolak. Postman kirim: '{$pengirimBersih}', Syarat: '{$pusatBersih}'");
            
        //     // JSON INI HARUS MUNCUL DI POSTMAN
        //     return response()->json([
        //         'message' => 'TIDAK COCOK',
        //         'data_dari_postman' => $pengirimBersih ?: 'KOSONG (Cek tab Body -> form-data di Postman)',
        //         'syarat_dari_database' => $pusatBersih
        //     ], 200);
        // }

        // // 3. JIKA LOLOS, LANJUT SIMPAN FILE
        // $files = $request->allFiles();
        // $fileLampiran = null;
        // $namaFileAsli = null;

        // if (!empty($files)) {
        //     $file = reset($files); 
        //     $namaFileAsli = $file->getClientOriginalName();
        //     $safeFileName = time() . '_' . \Illuminate\Support\Str::slug(pathinfo($namaFileAsli, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        //     $fileLampiran = $file->storeAs('dokumen', $safeFileName, 'public');
        // }

        // \App\Models\EmailMasuk::create([
        //     'pengirim' => $pengirim,
        //     'subjek' => $subjek,
        //     'isi_pesan' => $isiPesan,
        //     'file_lampiran' => $fileLampiran,
        //     'nama_file' => $namaFileAsli,
        //     'tanggal_terima' => now(),
        // ]);

        // return response()->json(['message' => 'SUKSES! Email masuk ke Inbox Staff.'], 200);
    }
}