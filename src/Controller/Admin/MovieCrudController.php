<?php

namespace App\Controller\Admin;

use App\Entity\Movie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MovieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Movie::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInSingular('Movie')
        ->setEntityLabelInPlural('Mvies')
        ->setPageTitle('new', 'Add Movie');
    }


    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('title');
        yield TextareaField::new('description');
        yield IntegerField::new('duration');
        yield ChoiceField::new('ageRating')
        ->setLabel('Age Reating')
        ->setChoices([
            '0+'=> '0+',
            '6+'=> '6+',
            '12+'=> '12+',
            '16+'=> '16+',
            '18+'=> '18+',
        ]);
        yield ImageField::new('poster')
        ->setBasePath('uploads/posters')
        ->setUploadDir('public/uploads/posters')
        ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]');
        yield BooleanField::new('isActive');
    }
}
