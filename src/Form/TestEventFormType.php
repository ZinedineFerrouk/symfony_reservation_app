<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestEventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event){
                $data = $event->getData();
                $form = $event->getForm();

                if ($data['name'] === 'Zinedine'){
                    $form->add('gender');
                }
            })
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event){
                $data = $event->getData();
                $form = $event->getForm();

                if ($data['name'] === 'Zinedine'){
                    $form->get('gender')->setData('man');
                }
            })

            ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'addMessageTextArea'])
            ->add('submit', SubmitType::class)
        ;
    }

    // Méthode qui va ajouter un TextArea au Submit du formulaire si le name = Zinedine
    public function addMessageTextArea(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if ($data['name'] === 'Zinedine'){
            $form->add('message', TextareaType::class);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
