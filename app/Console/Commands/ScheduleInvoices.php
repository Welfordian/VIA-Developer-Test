<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Invoice;
use Illuminate\Console\Command;

class ScheduleInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ScheduleInvoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule Invoices';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $invoices = Invoice::all(); // Fetch all the invoices 

        foreach($invoices as $invoice) // May need to chunk this up
        {
            echo "Invoice #" . $invoice->id . "\n";

            $start_date = new Carbon($invoice->start_date);

            if ($start_date < Carbon::now()) // If the start date has passed (active)
            {
                for($i = 0; $i < 3; $i++) // Start at zero as we want to include the original date
                {
                    $invoice_ordinal = $i + 1; // Revert to correct order

                    if($invoice->unit == "day")
                    {
                        $send_date = (new Carbon($invoice->start_date))->addDays($invoice->frequency * $i);
                    }
    
                    if ($invoice->unit == "month")
                    {
                        $send_date = (new Carbon($invoice->start_date))->addMonths($invoice->frequency * $i);
                    }
                    
                    echo ordinal_suffix($invoice_ordinal) . " invoice: " . $send_date->format("jS F Y") . "\n";
                }
            }

            echo "\n\n";
        }
    }
}
