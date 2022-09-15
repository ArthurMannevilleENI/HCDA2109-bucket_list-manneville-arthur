<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Wish;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WishFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $connectedUsername = $options['connectedUsername'];

        $builder
            ->add('title', TextType::class, [
                "label" => "Titre * :"
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description :"
            ])
            ->add('author', TextType::class, [
                "label" => "Auteur * :",
                "data" => $connectedUsername
            ])
            ->add('isPublished', ChoiceType::class, [
                "label" => "Publié ? :",
                "choices" => [
                    "Oui" => true,
                    "Non" => false
                ],
                "expanded" => true,
                "data" => true
            ])
            ->add('category', EntityType::class, [
                'attr' => [
                    'class' => "changeBackgroundDropdown"
                ],
                'label' => "Catégorie * :",
                'class' => Category::class,
                'choice_label' => 'name',
                'query_builder' => function(CategoryRepository $cr) {
                    return $cr->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                }
            ])

            ->add('save', SubmitType::class, [
                'label' => "Ajouter",
                'attr' => [
                    'class' => "formSubmit"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
            'connectedUsername' => null
        ]);
    }
}
