<?php

namespace App;

use App\Http\Traits\TimeFormat;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\UsesUUID;
use Carbon\Carbon;

class Plant extends Model
{
    use UsesUUID, TimeFormat;

    protected $fillable = [
        'name',
        'user_id'
    ];

    protected $appends = [
        'time_difference'
    ];

    public function getTimeDifferenceAttribute() {
        $diff = $this->currentTimestamp()->diffInSeconds($this->updated_at);

        if($diff < 10) {
            $diff = 'Baru saja';
        } else if($diff < 60) {
            $diff .= ' detik yang lalu';
        } else if($diff < 3600) {
            $diff = floor($diff / 60);
            $diff .= ' menit yang lalu';
        } else if($diff < 86400) {
            $diff = floor($diff / 3600);
            $diff .= ' jam yang lalu';
        } else if($diff < 604800) {
            $diff = floor($diff / 86400);
            $diff .= ' hari yang lalu';
        } else if($diff < 18144000) {
            $diff = floor($diff / 604800);
            $diff .= ' minggu yang lalu';
        } else if($diff < 217728000) {
            $diff = floor($diff / 18144000);
            $diff .= ' bulan yang lalu';
        } else {
            $diff = floor($diff / 18144000);
            $diff .= ' tahun yang lalu';
        }

        return $diff;
    }

    private function currentTimestamp() {
        return Carbon::now()->setTimezone('Asia/Jakarta');
    }

    public function growths() {
        return $this->hasMany(Growth::class)->orderBy('updated_at', 'desc');
    }
}