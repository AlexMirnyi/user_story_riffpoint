<?php

namespace App\MainBundle\Form\Type;

use App\MainBundle\Repository\AuthorRepository;
use App\MainBundle\Repository\BookRepository;
use App\MainBundle\Repository\GenreRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('authors', 'entity', [
            'multiple' => true,
            'label' => 'Автор/Авторы',
            'required' => false,
            'class' => 'App\MainBundle\Entity\Author',
            'attr' => ['class' => 'form-control'],
            'query_builder' => function(AuthorRepository $ar){
                    return $ar->createQueryBuilder('q')
                                ->orderBy('q.name', 'ASC');
            }
        ]);
        $builder->add('title', 'text', [
            'required' => false,
            'label' => 'Книга',
            'attr' => ['class' => 'form-control']
        ]);
        $builder->add('isbn', 'text', [
            'required' => false,
            'label' => 'ISBN',
            'attr' => ['class' => 'form-control']
        ]);
        $builder->add('genre', 'entity', [
            'multiple' => false,
            'required' => false,
            'label' => 'Жанр',
            'class' => 'App\MainBundle\Entity\Genre',
            'attr' => ['class' => 'form-control'],
            'query_builder' =>
                function (GenreRepository $gr){
                    return $gr->selectDistinctGenres();
            }
        ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'AppMainBundle',
            'data_class' => 'App\MainBundle\Entity\Book',
            'csrf_protection' => true,
        ]);
    }

    public function getName()
    {
        return 'app_main_bundle_book';
    }
} 