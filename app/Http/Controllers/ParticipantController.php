<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use DOMDocument;
use DOMXPath;

class ParticipantController extends Controller
{
    public function searchCallsign(Request $request)
    {
        $callsign = strtoupper(trim($request->callsign));

        if (!$callsign) {
            return response()->json(['status' => 'error', 'message' => 'Callsign wajib diisi.'], 422);
        }

        try {
            $url = "https://iar-ikrap.postel.go.id/registrant/searchDataIar/?callsign={$callsign}";
            $response = Http::timeout(10)->get($url);

            if ($response->failed()) {
                return response()->json(['status' => 'error', 'message' => 'Gagal menghubungi server IAR.'], 500);
            }

            $html = stripslashes($response->body());

            // Check if data not found
            if (str_contains($html, 'not-found.png') || str_contains($html, 'Data tidak ditemukan')) {
                return response()->json(['status' => 'not_found']);
            }

            // Parse using DOMDocument for more reliable parsing
            $dom = new DOMDocument();
            @$dom->loadHTML($html);
            $xpath = new DOMXPath($dom);

            // Get all title-meta and meta-details divs
            $titles = $xpath->query("//div[@class='title-meta']");
            $details = $xpath->query("//div[@class='meta-details']");

            if ($titles->length === 0 || $details->length === 0) {
                return response()->json(['status' => 'not_found']);
            }

            $result = [];
            for ($i = 0; $i < $titles->length; $i++) {
                $title = trim(preg_replace('/\s+/', ' ', $titles->item($i)->nodeValue));
                $value = trim(preg_replace('/\s+/', ' ', $details->item($i)->nodeValue));

                $cleanTitle = $this->mapTitle($title);
                if ($cleanTitle) {
                    $result[$cleanTitle] = $value;
                }
            }

            if (empty($result)) {
                return response()->json(['status' => 'not_found']);
            }
            return response()->json([
                'status' => 'success',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in searchCallsign', ['error' => $e->getMessage(), 'callsign' => $callsign]);
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat mencari data.'], 500);
        }
    }

    public function store(Request $request)
    {
        // Validasi awal tanpa cek duplikat callsign
        $validator = Validator::make($request->all(), [
            'event_id'      => 'required|exists:events,id',
            'callsign'      => 'required|string|max:100',
            'nama_peserta'  => 'required|string|max:150',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Cek duplikat callsign
        $exists = DB::table('pesertas')
            ->where('event_id', $request->event_id)
            ->where('callsign', strtoupper($request->callsign))
            ->exists();

        if ($exists) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Callsign ini sudah terdaftar untuk event ini.'
            ], 409); // HTTP 409 Conflict
        }

        try {
            // Generate nomor sertifikat
            $lastCertificate = DB::table('pesertas')
                ->where('event_id', $request->event_id)
                ->max('nomor_sertifikat');

            $certificateNumber = $lastCertificate ? ((int)$lastCertificate + 1) : 1;

            $participantId = DB::table('pesertas')->insertGetId([
                'event_id'         => $request->event_id,
                'callsign'         => strtoupper($request->callsign),
                'nama_peserta'     => $request->nama_peserta,
                'waktu_checkin'    => now(),
                'nomor_sertifikat' => str_pad($certificateNumber, 3, '0', STR_PAD_LEFT),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            $participant = DB::table('pesertas')
                ->where('id', $participantId)
                ->first();

            return response()->json([
                'status'  => 'success',
                'message' => 'Peserta berhasil ditambahkan',
                'data'    => $participant
            ]);
        } catch (\Exception $e) {
            \Log::error('Error adding participant', ['error' => $e->getMessage()]);
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menambahkan peserta'
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $deleted = DB::table('pesertas')
                ->where('id', $id)
                ->delete();

            if ($deleted) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Peserta berhasil dihapus'
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Peserta tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Error deleting participant', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus peserta'
            ], 500);
        }
    }

    public function getParticipants($eventId)
    {
        $participants = DB::table('pesertas')
            ->where('event_id', $eventId)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'callsign', 'nama_peserta', 'nomor_sertifikat', 'created_at']);

        return response()->json([
            'status' => 'success',
            'data' => $participants
        ]);
    }

    private function mapTitle($title)
    {
        $title = strtolower($title);

        // Remove content in parentheses if exists
        $title = preg_replace('/\(.*?\)/', '', $title);
        $title = trim($title);

        if (str_contains($title, 'nama pemilik')) {
            return 'nama_pemilik';
        } elseif (str_contains($title, 'provinsi')) {
            return 'provinsi';
        } elseif (str_contains($title, 'tanda panggilan')) {
            return 'callsign';
        } elseif (str_contains($title, 'masa laku')) {
            return 'masa_laku';
        } elseif (str_contains($title, 'status')) {
            return 'status';
        }

        return null;
    }
}
