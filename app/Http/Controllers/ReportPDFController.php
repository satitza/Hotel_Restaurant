<?php

namespace App\Http\Controllers;

use App\Report;
use PDF;
use Illuminate\Http\Request;

class ReportPDFController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('admin');
        $this->middleware('report');
    }

    public function test()
    {
        $reports = Report::all();
        $pdf = PDF::loadView('pdf.document', ['reports' => $reports]);
        return $pdf->stream('document.pdf');
    }
}