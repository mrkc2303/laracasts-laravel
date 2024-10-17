<?php

// WAY TO ORGANIZE YOUR CODE
namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Laravel uses auto loading standard called psr-4 (standard for autoloading files)
// this extending class with Model (make sure we are using Eloquent Model)
class Job extends Model {
    use HasFactory;
    protected $table = 'job_listings';

    // Fillable contains all the items that can be mass assigned as an array
    protected $fillable = ['employer_id', 'title', 'salary'];

    public function employer() {
        return $this->belongsTo(Employer::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, foreignPivotKey: "job_listing_id");
    }
}