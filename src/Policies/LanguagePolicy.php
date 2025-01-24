<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaLanguage\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LanguagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User|Authenticatable $user)
    {
        return true;
    }

    public function view(User|Authenticatable $user, $model)
    {
        return true;
    }

    public function create(User|Authenticatable $user)
    {
        return true;
    }

    public function update(User|Authenticatable $user, $model)
    {
        return true;
    }

    public function replicate(User|Authenticatable $user, $model)
    {
        return false;
    }

    public function delete(User|Authenticatable $user, $model)
    {
        return true;
    }

    public function forceDelete(User|Authenticatable $user, $model)
    {
        return false;
    }

    public function restore(User|Authenticatable $user, $model)
    {
        return false;
    }

    public function runAction(User|Authenticatable $user)
    {
        return true;
    }

    public function runDestructiveAction(User|Authenticatable $user)
    {
        return true;
    }
}
