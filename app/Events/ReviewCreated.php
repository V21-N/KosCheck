<?php

namespace App\Events;

use App\Models\Kos;
use App\Models\Review;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReviewCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Review $review,
        public Kos $kos
    ) {}
}
