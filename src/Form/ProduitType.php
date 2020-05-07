<?php

namespace App\Form;

use App\Entity\Enchere;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference')
            ->add('descriptif')
            ->add('name')
            ->add('prix')
            ->add('imageFile', FileType::class)
            ->add('connect', EntityType::class, [
                'class' => Enchere::class,
                'choice_label' => static function (Enchere $enchere) {
                    //j'ai ajouté l'heure
                    return $enchere->getDateDebut()->format('d/m/Y, H:m') . ' - ' . $enchere->getDateFin()->format('d/m/Y, H:m');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
