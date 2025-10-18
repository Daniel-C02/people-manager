<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait WireAlertTrait
{
    /**
     * Dispatches browser events to close modals and show a SweetAlert notification.
     *
     * @param string $type The type of alert ('success' or 'error').
     * @param string $message The message to display to the user.
     * @param string|null $errorLog An optional message to write to the error log.
     */
    private function sendAlert(
        string $type,
        string $message,
        ?string $errorLog = null,
        ?string $title = null,
    ): void
    {
        // Close any open modals
        $this->dispatch('close-modals');
        // Show an alert to the user
        $this->dispatch('dispatch-sweetalert', [
            'title' => $type == 'success'
                ? ($title ? $title : 'Success!')
                : 'Error!',
            'icon' => $type,
            'message' => $message,
        ]);
        // If an error log message is present, then log it
        if($errorLog) {
            Log::error($errorLog);
        }
    }
}
