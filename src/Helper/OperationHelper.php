<?php

namespace App\Helper;

use App\Entity\Operation;
use App\Entity\User;
use App\Repository\OperationRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class OperationHelper
{

    public function __construct(public EntityManagerInterface $entityManager)
    {
    }

    public function addCredit(?float $amount, User $user, bool $isVerified = true, bool $isApproved = true): void
    {
        if (isset($amount)) {
            $now = new DateTime();
            $operation = new Operation(
                '',
                0,
                'Retrait',
                0,
                $now,
                0,
                $now,
                0,
                -$amount,
                0,
                $user
            );
            $operation->setIsVerified(false);
            $operation->setIsApproved(false);
            $this->entityManager->persist($operation);
            $this->entityManager->flush();
        }
    }

    public function addRetrait(?float $amount, User $user, bool $isVerified = true, bool $isApproved = true): void
    {
        if (isset($amount)) {
            $now = new DateTime();
            $operationCredit = new Operation(
                '',
                0,
                'Credit',
                0,
                $now,
                0,
                $now,
                0,
                $amount,
                0,
                $user
            );
            $operationCredit->setIsVerified(false);
            $operationCredit->setIsApproved(false);
            $this->entityManager->persist($operationCredit);
            $this->entityManager->flush();
        }
    }

}



