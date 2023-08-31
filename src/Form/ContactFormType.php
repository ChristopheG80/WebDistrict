<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objet', TextType::class, [
                'attr' => ['placeholder' => 'Ici votre objet']
            ])

            ->add('email', EmailType::class)
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
                'empty_data' => 'Message laissé vide !!!',
                'required' => false,
                'attr' => ['rows' => '15', 'cols' => '40']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer le message',
                
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
