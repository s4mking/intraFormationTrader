<?php

namespace App\Service;

use App\Entity\User;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;

class AvatarService
{
    public function generateAvatar(User $user, int $size = 100): string
    {
        $avatar = new InitialAvatar();
        return $avatar->name($user->getFullName())->size($size)->generate()->stream('data-url');
    }
}
