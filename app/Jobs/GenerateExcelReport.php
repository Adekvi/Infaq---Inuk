<?php

namespace App\Jobs;

use App\Exports\Kolektor\DataExcel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class GenerateExcelReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        Log::info('Starting Excel generation for: ' . $this->data['filename']);
        try {
            Excel::store(
                new DataExcel(
                    $this->data['hasilinfaq'],
                    $this->data['filterOption'],
                    $this->data['tanggal'],
                    $this->data['months'],
                    $this->data['tahun'],
                    $this->data['showAll']
                ),
                $this->data['storagePath']
            );
            Log::info('Excel generated successfully: ' . $this->data['storagePath']);
        } catch (\Exception $e) {
            Log::error('Excel generation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
