<?php

namespace App\Controller\Admin;

use App\Entity\Operation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OperationCrudController extends AbstractCrudController
{

    public function __construct(

    ) {}
    public static function getEntityFqcn(): string
    {
        return Operation::class;
    }

     public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::DETAIL)
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('symbol'),
            NumberField::new('profit'),
            NumberField::new('openPrice'),
            NumberField::new('closePrice'),
            DateField::new('openTime'),
            DateField::new('closeTime'),
            AssociationField::new('transmitter'),
            BooleanField::new('isVerified'),
            BooleanField::new('isApproved')
        ];
    }

}
