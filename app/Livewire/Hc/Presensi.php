<?php

namespace App\Livewire\Hc;

use Livewire\Component;

class Presensi extends Component
{
    use \Livewire\WithPagination;

    public $filter = 'all';
    public $search = '';
    public $perPage = 10;
    public $showEditModal = false;
    public $editAttendanceId;
    public $editAttendanceData = [
        'date' => '',
        'check_in' => '',
        'status' => '',
        'keterangan' => '',
    ];

    public function render()
    {
        if ($this->filter === 'Belum Hadir') {
            $this->filterBelumHadirHariIni();
            $attendances = $this->attendances ?? collect();
        } else {
            $query = \App\Models\Attendance::with('user')
            ->orderBy('date', 'desc')
            ->orderBy('check_in', 'desc');

            if (!empty($this->search)) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            }

            if ($this->filter !== 'all') {
                $query->where('status', $this->filter);
            }

            $attendances = $query->paginate($this->perPage);
        }

        return view('livewire.hc.presensi', [
            'attendances' => $attendances,
        ])->layout('components.layouts.hc.app');
    }

    public function updatedSearch()
    {
        $this->filterData();
    }

    public function setFilter($status)
    {
        $this->filter = $status;
        $this->filterData();
    }

    private function filterData()
    {
        $query = \App\Models\Attendance::with('user')
            ->orderBy('date', 'desc')
            ->orderBy('check_in', 'desc');

        // Filter berdasarkan search
        if (!empty($this->search)) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        // Filter berdasarkan status
        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        $this->attendances = $query->paginate($this->perPage);
    }

    public function filterBelumHadirHariIni()
    {
        $today = now()->toDateString();

        // Ambil semua user magang aktif
        $userMagangIds = \App\Models\MagangApplication::where('status', 'on_going')
            ->pluck('user_id')
            ->toArray();

        // Ambil user yang sudah presensi hari ini
        $hadirIds = \App\Models\Attendance::whereDate('date', $today)
            ->pluck('user_id')
            ->toArray();

        // Query user yang belum presensi hari ini dan bisa di paginate
        $query = \App\Models\User::whereIn('id', $userMagangIds)
            ->whereNotIn('id', $hadirIds);

        // Tambahkan filter search
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $this->attendances = $query->paginate($this->perPage);
    }

    public function editAttendance($id)
    {
        $attendance = \App\Models\Attendance::findOrFail($id);
        $this->editAttendanceId = $id;
        $this->editAttendanceData = [
            'date' => $attendance->date,
            'check_in' => $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '',
            'status' => $attendance->status,
            'keterangan' => $attendance->keterangan,
        ];
        $this->showEditModal = true;
    }

    public function updateAttendance()
    {
        // Validasi input
        $this->validate([
            'editAttendanceData.date' => 'required|date',
            'editAttendanceData.check_in' => 'nullable|date_format:H:i',
            'editAttendanceData.status' => 'required|in:Hadir,Terlambat,Izin,Tidak Hadir',
            'editAttendanceData.keterangan' => 'nullable|string|max:255',
        ]);

        try {
            $attendance = \App\Models\Attendance::findOrFail($this->editAttendanceId);

            // Format check_in agar sesuai tipe database (misal time: H:i:s)
            $attendance->date = $this->editAttendanceData['date'];
            $attendance->check_in = $this->editAttendanceData['check_in']
                ? $this->editAttendanceData['check_in'] . ':00'
                : null;
            $attendance->status = $this->editAttendanceData['status'];
            $attendance->keterangan = $this->editAttendanceData['keterangan'];
            $attendance->save();

            $this->showEditModal = false;
            $this->filterData();
            session()->flash('message', 'Presensi berhasil diupdate');
        } catch (\Exception $e) {
            session()->flash('message', 'Terjadi kesalahan saat update presensi: ' . $e->getMessage());
        }
    }

    public function deleteAttendance($id)
    {
        try {
            $attendance = \App\Models\Attendance::findOrFail($id);
            $attendance->delete();
            $this->filterData();
            session()->flash('message', 'Presensi berhasil dihapus');
        } catch (\Exception $e) {
            session()->flash('message', 'Terjadi kesalahan saat menghapus presensi: ' . $e->getMessage());
        }
    }

    public function getUnitById($userId)
    {
        try {
            $magang = \App\Models\MagangApplication::where('user_id', $userId)
                ->orderBy('tanggal_mulai_usulan', 'desc')
                ->first();

            return $magang->unit_penempatan ?? '-';
        } catch (\Exception $e) {
            return '-';
        }
    }
}
