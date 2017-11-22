<?php

namespace App\Jobs;

use App\Traits\CreateLabelPrint;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use View;
use Log;
use Config;

class processCartonLabels implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,CreateLabelPrint;

    public $cartondata;
    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $cartondata)
    {
        $this->cartondata = $cartondata;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!empty($this->cartondata)) {
            $mixed = 0;
            foreach ($this->cartondata as $type => $cartons) {
                if (strtolower($type) == strtolower(Config::get('ticket.mixed.type'))) {
                    $mixed = Config::get('ticket.mixed.quantity');
                }

                if ($cartons) {
                    $view = View::make('labels.templates.'.$type, ['data' => $cartons, 'mixed' => $mixed]);
                    $raw_data = (string) $view;

                    try {
                        //add it to user label print
                        $this->addLabelPrint($cartons, $raw_data, $type);
                    } catch (Exception $e) {
                        Log::info('Exception running queue job processCartonLabels '. $e->getMessage());
                    }
                }
            }
        }
    }
}
