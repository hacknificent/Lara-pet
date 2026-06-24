<?php

namespace App\Http\Controllers;

use App\Models\ProjectIdea;

class ProjectIdeaRescaleController extends Controller
{
    /**
     * Check if rescaling is enabled (easily toggleable).
     */
    public function rescaleIsEnabled(): bool
    {
        return true; // Set to false to disable rescaling
    }

    /**
     * Decimal places threshold for triggering rescale.
     */
    public function rescaleDecimalThreshold(): int
    {
        return 3; // Trigger rescale when order has more than 3 decimal places
    }

    /**
     * Check if order value exceeds decimal precision threshold.
     */
    public function shouldRescaleOrder(float $order): bool
    {
        $str = (string) $order;
        if (strpos($str, '.') === false) {
            return false;
        }

        $decimals = strlen(substr(strrchr($str, '.'), 1));
        return $decimals > $this->rescaleDecimalThreshold();
    }

    /**
     * Rescale all orders for a given status to fresh sequential values.
     */
    public function rescaleOrderForStatus(int $status): void
    {
        $ideas = ProjectIdea::where('status', $status)
            ->orderBy('order')
            ->get();

        foreach ($ideas as $index => $idea) {
            $idea->update(['order' => (float) ($index + 1)]);
        }
    }
}
