<?php

namespace Webkul\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Blog\Contracts\Post as PostContract;

class Post extends Model implements PostContract
{
    protected $fillable = [];
}