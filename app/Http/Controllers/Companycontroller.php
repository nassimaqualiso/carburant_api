<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;

class Companycontroller extends Controller
{

    use CrudTrait;
    public function __construct()
    {
        $this->Model = Company::class;
    }

}
