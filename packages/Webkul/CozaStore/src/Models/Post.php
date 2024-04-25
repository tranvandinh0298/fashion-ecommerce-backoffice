<?php

namespace Webkul\CozaStore\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\CozaStore\Contracts\Post as PostContract;

class Post extends Model implements PostContract
{
    protected $fillable = [];
}