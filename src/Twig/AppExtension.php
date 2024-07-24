<?php
namespace App\Twig;

use App\Entity\User;
use App\Service\AvatarService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    private AvatarService $avatarService;

    public function __construct(AvatarService $avatarService)
    {
        $this->avatarService = $avatarService;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('avatar', [$this, 'getAvatar']),
        ];
    }

    public function getAvatar(User $user, int $size = 100): string
    {
        return $this->avatarService->generateAvatar($user, $size);
    }
}
