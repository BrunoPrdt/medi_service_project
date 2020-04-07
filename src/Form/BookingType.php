<?php

namespace App\Form;

use App\Entity\Reservations;
use App\Form\DataTransformer\TextToDateTimeDataTransformer;
use App\Repository\ArticlesRepository;
use App\Repository\ProspectsRepository;
use App\Repository\UsersRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    /**
     * @var UsersRepository
     */
    private $usersRepository;
    /**
     * @var ProspectsRepository
     */
    private $prospectsRepository;
    /**
     * @var ArticlesRepository
     */
    private $articlesRepository;
    /**
     * @var TextToDateTimeDataTransformer
     */
    private $transformer;
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    public function __construct(TextToDateTimeDataTransformer $transformer, UsersRepository $usersRepository, ProspectsRepository $prospectsRepository, ArticlesRepository $articlesRepository, \Doctrine\Common\Persistence\ManagerRegistry $registry)
    {
        $this->managerRegistry = $registry;
        $this->usersRepository = $usersRepository;
        $this->prospectsRepository = $prospectsRepository;
        $this->articlesRepository= $articlesRepository;
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user')
            ->add('prospect')
            ->add('viewDate', TextType::class, [
                'required' => false,
                'attr' => [
                    'data-provide' => 'datepicker'
                ],
            ])
            ->add('loanDate', TextType::class, [
                'required' => true,
                'attr' => [
                    'data-provide' => 'datepicker'
                ],
            ])
            ->add('returnDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('realReturnDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('availabilityDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('returnComment')
        ;

        $builder->get('loanDate')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
