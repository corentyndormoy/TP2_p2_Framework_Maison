<?php

namespace App\Controller;


use App\Entity\Player;
use App\Entity\Game;
use App\Entity\Score;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ScoreController extends AbstractController
{
    /**
     * Affiche la page des scores
     * 
     * @Route("/score", name="score")
     * 
     * @param Request                   $request
     * @param EntityManagerInterface    $entityManager
     * 
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $scoreRepository = $entityManager->getRepository(Score::class);
        $scores = $scoreRepository->findAll();

        $playerRepository = $entityManager->getRepository(Player::class);
        $players = $playerRepository->findAll();

        $gameRepository = $entityManager->getRepository(Game::class);
        $games = $gameRepository->findAll();

        return $this->render("score/index.html.twig", ["scores" => $scores,
            "games" => $games, "players" => $players]);
    }

    /**
     * Ajoute un score
     * 
     * @Route("/score/add", name="score_add")
     * 
     * @param Request                   $request
     * @param EntityManagerInterface    $entityManager
     * 
     * @return Response
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->getMethod() == Request::METHOD_POST) {
            $playerRepository = $entityManager->getRepository(Player::class);
            $player = $playerRepository->find($request->get("player"));

            $gameRepository = $entityManager->getRepository(Game::class);
            $game = $gameRepository->find($request->get("game"));


            $score = new Score();
            $score->setCreatedAt(new \DateTime());
            $score->setGame($game);
            $score->setPlayer($player);
            $score->setScore($request->get("score"));

            $entityManager->persist($score);
            $entityManager->flush();

            return $this->redirectTo("/score");
        }
    }

    /**
     * Supprime un score
     * 
     * @Route("/score/delete/{id}", name="score_delete")
     * 
     * @param                           $id
     * @param EntityManagerInterface    $entityManager
     * 
     * @return Response
     */
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $scoreRepository = $entityManager->getRepository(Score::class);
        $score = $scoreRepository->find($id);

        $entityManager->remove($score);
        $entityManager->flush();
        
        return $this->redirectTo("/score");

    }
}
