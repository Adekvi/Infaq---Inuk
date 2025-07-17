<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GeneratePdfReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle(): void
    {
        Log::info('Starting PDF generation for: ' . $this->data['filename']);
        try {
            $pdf = Pdf::loadView('kolektor.report.cetak.pdf', $this->data)
                ->setPaper('a4', 'landscape');
            Storage::makeDirectory('public/laporan/pdf');
            $pdf->save(storage_path('app/' . $this->data['storagePath']));
            Log::info('PDF generated successfully: ' . $this->data['storagePath']);
        } catch (\Exception $e) {
            Log::error('PDF generation failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
