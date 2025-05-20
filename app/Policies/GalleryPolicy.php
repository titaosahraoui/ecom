<?php

namespace App\Policies;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GalleryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Gallery $gallery)
    {
        return $gallery->approved || $user->id === $gallery->user_id || $user->hasRole('admin');
    }

    public function create(User $user)
    {
        return $user->hasRole('commercial') || $user->hasRole('admin');
    }

    public function update(User $user, Gallery $gallery)
    {
        return $user->id === $gallery->user_id || $user->hasRole('admin');
    }

    public function delete(User $user, Gallery $gallery)
    {
        return $user->id === $gallery->user_id || $user->hasRole('admin');
    }

    public function approve(User $user)
    {
        return $user->hasRole('admin');
    }
}
