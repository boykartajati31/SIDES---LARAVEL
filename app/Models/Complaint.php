<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    //
    protected $guarded = [];

    public function getStatuslabelAttribute() //status_label
    {
        return match ($this->status) {
            'new'               => 'Baru',
            'processing'        => 'Sedang di Proses',
            'completed'         => 'Selesai',
            default             => 'Tidak Ada',
        };
    }

    public function getReportDateLabelAttribute() //report_Date_label
    {
        return \Carbon\Carbon::parse($this->report_date)->format('d M Y H:i:s');
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
