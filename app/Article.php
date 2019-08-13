<?php

namespace App;

use Hyn\Tenancy\Traits\UsesSystemConnection;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use UsesTenantConnection;
//    use UsesSystemConnection;
}

