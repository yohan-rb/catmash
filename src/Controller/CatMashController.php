<?php

namespace App\Controller;

use App\Repository\CatRepository;
use App\Services\CatmashHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatMashController extends AbstractController
{
    /**
     * @Route("/meow", name="cat_mash", methods="GET")
     * @param CatmashHandler $catmashHandler
     * @return Response
     */
    public function index(CatmashHandler $catmashHandler): Response
    {
        $antagonists = $catmashHandler->getAntagonists(2);

        $catmashHandler->increaseDisplayedCats($antagonists);

        return $this->render("home.html.twig",[
            'antagonists' => $antagonists
        ]);
    }

    /**
     * @Route("/vote", name="vote", methods="GET")
     * @param Request $request
     * @param CatmashHandler $catmashHandler
     * @return Response
     */
    public function vote(Request $request, CatmashHandler $catmashHandler) : Response
    {
        $ref = $request->query->get('ref');

        //increase voted cat count
        $catmashHandler->increaseVotedCats($ref);

        return $this->json(["success" => "true"]);
    }

    /**
     * @Route("/result", name="result", methods="GET")
     * @param CatRepository $cr
     * @param CatmashHandler $catmashHandler
     * @return Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function result(CatRepository $cr, CatmashHandler $catmashHandler): Response
    {
        $result = $catmashHandler->getSortedResult();

        return $this->render("result.html.twig",[
            'result' => $result,
            'totalVoted' => $cr->getTotalVoted()
        ]);
    }
}
