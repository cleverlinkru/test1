<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'birthdate',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function getName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAgeAttribute()
    {
        $age = $this->calcAge();
        if ($age->y > 0) {
            return $age->y;
        } elseif ($age->m > 0) {
            return $age->m;
        } elseif ($age->d > 0) {
            return $age->d;
        }
        return null;
    }

    public function getAgeTypeAttribute()
    {
        $age = $this->calcAge();
        if ($age->y > 0) {
            return 'лет';
        } elseif ($age->m > 0) {
            return 'месяцев';
        } elseif ($age->d > 0) {
            return 'дней';
        }
        return null;
    }

    public function getAgeTextAttribute()
    {
        return $this->age . ' ' . $this->age_type;
    }


    protected $calcAge = null;

    protected function calcAge()
    {
        if ($this->calcAge) {
            return $this->calcAge;
        }

        $birthdate = new Carbon($this->birthdate);
        $now = Carbon::now();
        $this->calcAge = $birthdate->diff($now);

        return $this->calcAge;
    }
}
