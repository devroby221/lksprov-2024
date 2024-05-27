<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'limit_one_response'
    ];

    /**
     * The user that belong to the Form
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get all of the allowed_domains for the Form
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allowed_domains()
    {
        return $this->hasMany(AllowedDomain::class);
    }

    /**
     * Get all of the questions for the Form
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
