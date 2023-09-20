<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /** table name
     * @var string
     */
    protected $table = 'departments';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(company::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
