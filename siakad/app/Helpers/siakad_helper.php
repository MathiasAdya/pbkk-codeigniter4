<?php

/** Bobot nilai huruf untuk perhitungan IP. */
const NILAI_BOBOT = ['A' => 4.0, 'AB' => 3.5, 'B' => 3.0, 'BC' => 2.5, 'C' => 2.0, 'D' => 1.0, 'E' => 0.0];

if (! function_exists('user')) {
    /** Ambil data user yang sedang login dari session. */
    function user(?string $key = null)
    {
        $data = session()->get('user') ?? [];

        return $key === null ? $data : ($data[$key] ?? null);
    }
}

if (! function_exists('hitung_ip')) {
    /**
     * Hitung IP dari daftar baris [sks, nilai]. Matakuliah tanpa nilai tidak dihitung.
     *
     * @param list<array{sks:int|string, nilai:?string}> $rows
     */
    function hitung_ip(array $rows): array
    {
        $sks = 0;
        $mutu = 0.0;

        foreach ($rows as $row) {
            if ($row['nilai'] === null || ! isset(NILAI_BOBOT[$row['nilai']])) {
                continue;
            }
            $sks  += (int) $row['sks'];
            $mutu += (int) $row['sks'] * NILAI_BOBOT[$row['nilai']];
        }

        return ['sks' => $sks, 'ip' => $sks > 0 ? round($mutu / $sks, 2) : 0.0];
    }
}
