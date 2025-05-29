<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function create(User $user): bool
    {
        return true; // Any authenticated user can create reviews
    }

    public function update(User $user, Review $review): bool
    {
        return $user->id === $review->user_id; // Users can only update their own reviews
    }

    public function delete(User $user, Review $review): bool
    {
        return $user->id === $review->user_id; // Users can only delete their own reviews
    }

    public function approve(User $user, Review $review): bool
    {
        return false; // Regular users cannot approve reviews
    }

    public function reject(User $user, Review $review): bool
    {
        return false; // Regular users cannot reject reviews
    }
} 