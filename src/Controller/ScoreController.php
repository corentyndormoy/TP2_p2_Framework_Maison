<?php

namespace App\Controller;


use App\Entity\Player;
use App\Entity\Game;
use App\Entity\Score;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class ScoreController extends AbstractController
{
    /**
     * Affiche la page des scores
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
}
