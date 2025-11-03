<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Job extends Model
{
    use HasFactory;
    protected $table = 'job_listings';
    protected $fillable = [
        'title',
        'description',
        "salary",
        "tags",
        "job_type",
        "remote",
        "requirements",
        "benefits",
        "address",
        "city",
        "state",
        "zipcode",
        "contact_email",
        "contact_phone",
        "company_name",
        "company_description",
        "company_logo",
        "company_website",
        'user_id'
    ];

    // relation to user
    public function user() {
        return $this->belongsTo(User::class);
    }
}
