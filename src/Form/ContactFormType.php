<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class ContactFormType extends AbstractType
{
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer=$mailer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objet', TextType::class, [
                'attr' => ['placeholder' => 'Ici votre objet'],
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a message',
                    ]),
                ]
                
            ])

            ->add('email', EmailType::class, [
                'required' => false,
                'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a message',
                ]),
                new Email([
                    'message' => 'email non valide',
                ])
            ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
                // 'empty_data' => 'Message laissé vide !!!',
                'required' => false,
                'attr' => ['rows' => '15', 'cols' => '40'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a message',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your message should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer le message',
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
