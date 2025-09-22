<?php

namespace App\Exports;

use App\Models\MagangApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MagangExport implements FromCollection, WithHeadings
{
    protected $filter;
    protected $search;

    public function __construct($filter = 'all', $search = '')
    {
        $this->filter = $filter;
        $this->search = $search;
    }

    public function collection()
    {
        $query = MagangApplication::with('user');

        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        return $query->get()->map(function ($item) {
            return [
                'Nama' => $item->user->name ?? '-',
                'Email' => $item->user->email ?? '-',
                'Status' => ucfirst(str_replace('_', ' ', $item->status)),
                'Unit Penempatan' => $item->unit_penempatan ?? '-',
                'Tanggal Mulai Usulan' => $item->tanggal_mulai_usulan 
                    ? \Carbon\Carbon::parse($item->tanggal_mulai_usulan)->format('d M Y') : '-',
                'Tanggal Selesai Usulan' => $item->tanggal_selesai_usulan
                    ? \Carbon\Carbon::parse($item->tanggal_selesai_usulan)->format('d M Y') : '-',
                'Durasi Magang' => $item->durasi_magang ?? '-',
                'Tanggal Daftar' => \Carbon\Carbon::parse($item->created_at)->format('d M Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'Status',
            'Unit Penempatan',
            'Tanggal Mulai Usulan',
            'Tanggal Selesai Usulan',
            'Durasi Magang',
            'Tanggal Daftar',
        ];
    }
}
