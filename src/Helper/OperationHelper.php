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
            $operation = new Operation();
            $operation->setSymbol('');
            $operation->setPosition(0);
            $operation->setType('Credit');
            $operation->setLots(0);
            $operation->setOpenPrice(0);
            $operation->setOpenTime($now);
            $operation->setClosePrice(0);
            $operation->setCloseTime($now);
            $operation->setProfit($amount);
            $operation->setNetProfit(0);
            $operation->setTransmitter($user);
            $operation->setIsVerified($isVerified);
            $operation->setIsApproved($isApproved);
            $this->entityManager->persist($operation);
            $this->entityManager->flush();
        }
    }

    public function addRetrait(?float $amount, User $user, bool $isVerified = true, bool $isApproved = true): void
    {
        if (isset($amount)) {
            $now = new DateTime();
            $operationCredit = new Operation();
            $operationCredit->setSymbol('');
            $operationCredit->setPosition(0);
            $operationCredit->setType('Retrait');
            $operationCredit->setLots(0);
            $operationCredit->setOpenPrice(0);
            $operationCredit->setOpenTime($now);
            $operationCredit->setClosePrice(0);
            $operationCredit->setCloseTime($now);
            $operationCredit->setProfit(-$amount);
            $operationCredit->setNetProfit(0);
            $operationCredit->setTransmitter($user);
            $operationCredit->setIsVerified($isVerified);
            $operationCredit->setIsApproved($isApproved);
            $this->entityManager->persist($operationCredit);
            $this->entityManager->flush();
        }
    }

}



