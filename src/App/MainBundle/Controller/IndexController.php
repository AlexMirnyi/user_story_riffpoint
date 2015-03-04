<?php

namespace App\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\MainBundle\Repository\BookRepositor;

class IndexController extends Controller
{

    /**
     * @Route("/", name="main_page")
     */
    public function indexAction(Request $request)
    {

        /** @var BookRepository $bookRepo */
        $bookRepo = $this->get('main.book.repository');

        $perPage = $this->container->getParameter('per_page');
        /** @var Form $searchForm */
        $searchForm = $this->get('app_main_bundle.form.book');

        $amountOfPages = ceil(COUNT($bookRepo->findAll()) / $perPage);
        $pages = range(1, $amountOfPages, 1);

        $returnArray = [];
        $returnArray['page'] = 0;
        $returnArray['subs'] = $bookRepo->selectBooksWithSubAuthors();

        if($request->getMethod() == "POST"){
            $searchForm->submit($request->request->get($searchForm->getName()));
            $formData = $searchForm->getViewData();

            $params = [
                'title' => $formData->getTitle(),
                'isbn' => $formData->getIsbn(),
                'genre' => !is_null($formData->getGenre()) ? $formData->getGenre()->getType() : null ,
                'authors' => []
            ];

            if(count($formData->getAuthors())) {
                foreach ($formData->getAuthors() as $author) {
                    array_push($params['authors'], $author->getId());
                }
            }

            $filteredData = $bookRepo->getFilterData(1, $perPage, 0, $params, true);
            $amountOfPages = ceil(COUNT($bookRepo->getFilterData(1, $perPage, 0, $params, false)) / $perPage);
            $pages = range(1, $amountOfPages, 1);

            $returnArray['books'] = $this->getPageContent($filteredData);
            $returnArray['pages'] = count($filteredData) ? $pages : 0;
            $returnArray['form'] = $searchForm->createView();

            return $this->render('AppMainBundle:Index:index.html.twig', $returnArray);
        }

        $returnArray['books'] = $this->getPageContent($bookRepo->load(1, $perPage, 0));
        $returnArray['pages'] = $pages;
        $returnArray['form'] = $searchForm->createView();

        return $this->render('AppMainBundle:Index:index.html.twig', $returnArray);
    }

    /**
     * @Route("/load-elements", name="main_elements_load")
     * @Method("POST")
     */
    public function loadElementsAction(){

        $elementsAfterPag = $this->get('main.book.repository')->getFilterData(
            $this->get('request')->request->get('page'),
            $this->container->getParameter('per_page'), 10,
            $this->get('request')->request->get('params'),  true);

        $content = $this->render('AppMainBundle:index:table.html.twig', ['books' => $this->getPageContent($elementsAfterPag), 'page' => $this->get('request')->request->get('page') - 1])->getContent();

        return new JsonResponse($content);
    }

    public function getPageContent($content){
        $resArr = [];
        $authors = [];
        foreach($content as $b){
            foreach($b->getAuthors() as  $a){
                if(array_key_exists($b->getId(), $authors)){
                    array_push($authors[$b->getId()], $a->getName());
                } else{
                    $authors[$b->getId()] = [$a->getName()];
                }
                $resArr[$b->getId()] = [
                    'isbn' => $b->getIsbn(),
                    'title' => $b->getTitle(),
                    'genre' => $b->getGenre()->getType(),
                    'published' => $b->getPublisher()->getPublished()
                ];
            }
            $resArr[$b->getId()]['authors'] = $authors[$b->getId()];
        }
        return $resArr;
    }
}
