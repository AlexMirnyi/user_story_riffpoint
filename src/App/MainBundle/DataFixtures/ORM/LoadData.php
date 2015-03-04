<?php
namespace App\MainFaqBundle\DataFixtures\ORM;

use App\MainBundle\Entity\Author;
use App\MainBundle\Entity\Book;
use App\MainBundle\Entity\Genre;
use App\MainBundle\Entity\Publisher;
use App\MainBundle\Repository\AuthorRepository;
use App\MainBundle\Repository\BookRepository;
use App\MainBundle\Repository\PublisherRepository;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \DOMDocument;
use \DOMXPath;
use Symfony\Component\Validator\Constraints\DateTime;

class LoadData extends AbstractFixture implements
    OrderedFixtureInterface,
    ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $dom = new DOMDocument();
        $dom->recover = true;
        $dom->strictErrorChecking = false;
        @$dom->loadHTML(file_get_contents('http://booksbest.org/rejtingi-luchshikh-knig/26-100-velichajshikh-romanov-vsekh-vremen-po-versii-observer'));
        $table = $dom->getElementsByTagName('table');

        $arr = [];
        $infoArr = [];
        $genres = ['роман', 'рассказ', 'повесть', 'комедия', 'драма', 'новелла'];
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.entity_manager');

        foreach($table->item(0)->getElementsByTagName('tr') as $tr){
            foreach($tr->getElementsByTagName('td') as $td){
                $arr[] = $td->nodeValue;
            }
        }
        foreach(array_chunk($arr, 3) as $chunk){
            $infoArr[] = [
                'name' => $chunk[1],
                'title' => $chunk[0],
                'year' => $chunk[2]
            ];
        }

        /** @var AuthorRepository $authorRepo */
        $authorRepo = $this->container->get('main.author.repository');
        /** @var BookRepository $bookRepo */
        $bookRepo = $this->container->get('main.book.repository');
        /** @var GenreRepository $genreRepo */
        $genreRepo = $this->container->get('main.genre.repository');
        /** @var PublisherRepository $publisherRepo */
        $publisherRepo = $this->container->get('main.publisher.repository');

        if(count($infoArr)) {

            foreach($infoArr as $info){

                $i = uniqid();

                /** @var Author $author */
                $author = $authorRepo->create();

                /** @var Book $book */
                $book = $bookRepo->create();

                /** @var Genre $genre */
                $genre = $genreRepo->create();
                $genre->setType($genres[array_rand($genres)]);

                /** @var Publisher $publisher */
                $publisher = $publisherRepo->create();
                $publisher->setPublished($info['year']);
                $publisher->setEdition('some edition ' . mt_rand(1900, 2015));

                $author->addBook($book);
                $book->addAuthor($author);
                $book->setPublisher($publisher);
                $author->setName($info['name']);
                $book->setTitle($info['title']);
                $book->setIsbn('isbn' . $info['year'] . $i);
                $book->setGenre($genre);

                $em->persist($author);
                $em->persist($book);
                $em->persist($genre);
                $em->persist($publisher);
            }

            $em->flush();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}