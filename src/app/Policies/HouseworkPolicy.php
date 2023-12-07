<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class HouseworkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->id === auth()->user()->id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): Response|bool
    {
        return $user->id === auth()->user()->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response|bool
    {
        return $user->id === auth()->user()->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response|bool
    {
        return $user->id === auth()->user()->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response|bool
    {
        return $user->id === auth()->user()->id;
    }
}
