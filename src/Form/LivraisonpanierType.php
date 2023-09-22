<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Utilisateur;
use PhpParser\Parser\Multiple;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Email;


class LivraisonpanierType extends AbstractType
{
    private $mailer;
    const _WIRE_TRANSFERT = 0;
    const _PAYPAL = 1;
    const _BANK_CARD = 2;
    const _CASH = 3;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        // $Utilisateur = $this->getUser();
        $Utilisateur = new Utilisateur();
        
        $builder


            ->add('nom', TextType::class, [
                'attr' => [
                    // 'disabled' => 'disable',
                    'placehoder' => 'nom de l\'utilisateur enregistré',
                    'value' => $Utilisateur->getNom()
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    // 'disabled' => 'disable',
                    'value' => $Utilisateur->getPrenom()
                ]
            ])
            ->add('telephone', TextType::class, [
                'attr' => [
                    // 'value' => '0607080910'
                    'value' => $Utilisateur->getTelephone()
                ],
                'constraints' => [
                    new Regex('#^[0-9]{10}$#'),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Your message should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 10,
                    ]),
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    // 'value' => 'admin@admin.com'
                    'value' => $Utilisateur->getEmail()
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a message',
                    ]),
                    new Email([
                        'message' => 'email non valide',
                    ])
                ]
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse de livraison',
                    // 'value' => '43 rue de Turenne'
                    'value' => $Utilisateur->getAdresse()
                ]
            ])
            ->add('cp', TextType::class, [
                'attr' => [
                    //     'value' => 15360
                    'value' => $Utilisateur->getCP()
                ],
                'constraints' => [
                    new Regex('#^[0-9]{5}$#'),
                    // new NotBlank([
                    //     'message' => 'Mettre le code postal pour la facturation',
                    // ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Your message should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 5,
                    ]),
                ]
            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'value' => $Utilisateur->getVille()
                ]
            ])

            ->add('adresseLiv', TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse de livraison',
                    // 'value' => 'adresse de livraison'
                    'value' => $Utilisateur->getAdresse()
                ],

            ])
            ->add('cpLiv', TextType::class, [
                'attr' => [
                    'value' => $Utilisateur->getCP()
                ],

                'constraints' => [
                    new Regex('#^[0-9]{5}$#'),
                    new NotBlank([
                        'message' => 'Mettre le code postal pour la livraison',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Your message should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 5,
                    ]),
                ]
            ])
            ->add('villeLiv', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ville de livraison',
                    'value' => $Utilisateur->getVille()
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer la ville de livraison'
                    ])
                ]
            ])

            ->add('moyenPaiement', ChoiceType::class, [
                'choices'  => [
                    'Carte Bleue' => '_BANK_CARD',
                    'Virement' => '_WIRE_TRANSFERT',
                    'Paypal' => '_PAYPAL',
                ]
            ])
            ->add('cgu', CheckboxType::class, [
                'value'  => 'CGU',
            ])

            ->add('save', SubmitType::class, [
                'label' => 'Payer la commande',

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'data_class' => Utilisateur::class,
        ]);
    }
}
