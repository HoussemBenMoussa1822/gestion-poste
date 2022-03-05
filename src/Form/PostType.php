<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
        ->add('type', ChoiceType::class, [
            'choices' => [
                'type1' => 'type1',
                'type2' => 'type2',
            ],
        ])
            ->add('description')
            
            ->add('image', FileType::class,[
                
                'mapped' => false
               
                
            ])
            ->add('localisation')
            ->add('confirmer',SubmitType::class,[
                'attr' => ['class' => 'btn btn-primary'],
            ])             
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
