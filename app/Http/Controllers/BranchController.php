<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;

class BranchController extends Controller
{

    use CrudTrait;
    public function __construct()
    {
        $this->Model = Branch::class;
    }

}
