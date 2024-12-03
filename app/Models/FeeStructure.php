<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeeStructure extends Model
{
    use HasFactory;

    protected $fillable = ['academic_year_id','fee_head_id','class_id', 'month01', 'month02', 'month03', 'month04', 'month05', 'month06', 'month07', 'month08', 'month09', 'month10', 'month11', 'month12'];

    public function FeeHead(){
        return $this->belongsTo(FeeHead::class, 'fee_head_id');
    }

    public function AcademicYear(){
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function Classes(){
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
