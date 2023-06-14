<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    use CrudTrait;
    public function __construct()
    {
        $this->Model = Center::class;
    }
}
