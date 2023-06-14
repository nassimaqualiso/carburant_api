<?php

namespace App\Http\Controllers;

use App\Models\SubNature;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;

class SubNatureController extends Controller
{
    use CrudTrait;
    public function __construct()
    {
        $this->Model = SubNature::class;
    }
}
