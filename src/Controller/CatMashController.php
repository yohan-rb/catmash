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
     */
    public function result(CatRepository $cr): Response
    {
        $scoring = $cr->getScoring();

        return $this->render("result.html.twig",[
            'scoring' => $scoring
        ]);
    }
}
