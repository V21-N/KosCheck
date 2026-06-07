<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public const TYPE_INACCURATE = 'inaccurate';
    public const TYPE_FAKE = 'fake';
    public const TYPE_INAPPROPRIATE = 'inappropriate';
    public const TYPE_SPAM = 'spam';
    public const TYPE_OTHER = 'other';
}
