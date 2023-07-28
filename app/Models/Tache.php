<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [ 'date_start', 'date_end', 'description', 'employee_id'];

    // protected $casts = [
    //     'date_start' => 'datetime:Y/m/d TH:i',
    //     'date_end' => 'datetime:Y/m/d TH:i',
    // ];parse($value)->format('Y-m-d H:i')

    public function getDateStartAttribute($value){
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function getDateEndAttribute($value){
        return Carbon::parse($value)->format('Y-m-d H:i');
    }
}
