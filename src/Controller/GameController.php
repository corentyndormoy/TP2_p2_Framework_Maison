<?php

namespace App\Controller;


use App\FakeData;
use App\Entity\Game;
use App\Entity\Score;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class GameController extends AbstractController
{
    /**
     * Affiche la page des jeux
     * 
     * @param Request                   $request
     * @param EntityManagerInterface    $entityManager
     * 
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gameRepository = $entityManager->getRepository(Game::class);
        $games = $gameRepository->findAll();

        return $this->render("game/index", ["games" => $games]);

    }

    /**
     * Ajoute un jeu
     * 
     * @param Request                   $request
     * @param EntityManagerInterface    $entityManager
     * 
     * @return Response
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fakeGame = FakeData::games(1)[0];
        $fakeName = $fakeGame["name"];
        $fakeImage = $fakeGame["image"];

        $game = new Game();
        $game->setName($fakeName);
        $game->setImage($fakeImage);

        if ($request->getMethod() == Request::METHOD_POST) {
            $game->setName($request->get("name"));
            $game->setImage($request->get("image"));

            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectTo("/game");
        }

        return $this->render("game/form", ["game" => $game]);
    }


    /**
     * Affiche les détails d'un jeu
     * 
     * @param                           $id
     * @param EntityManagerInterface    $entityManager
     * 
     * @return Response
     */
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $gameRepository = $entityManager->getRepository(Game::class);
        $game = $gameRepository->find($id);

        $scoreRepository = $entityManager->getRepository(Score::class);
        $scores = $scoreRepository->findBy(["game" => $game], ["score" => "DESC"]);
        
        return $this->render("game/show", [
            "game" => $game,
            "scores" => $scores
            ]);
    }


    /**
     * Modifie un jeu
     * 
     * @param                           $id
     * @param Request                   $request
     * @param EntityManagerInterface    $entityManager
     * 
     * @return Response
     */
    public function edit($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $gameRepository = $entityManager->getRepository(Game::class);
        $game = $gameRepository->find($id);

        if ($request->getMethod() == Request::METHOD_POST) {
            $game->setName($request->get("name"));
            $game->setImage($request->get("image"));

            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectTo("/game");
        }
        
        return $this->render("game/form", ["game" => $game]);
    }

    /**
     * Supprime un jeu
     * 
     * @param $id
     * @param EntityManagerInterface $entityManager
     * 
     * @return Response
     */
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $gameRepository = $entityManager->getRepository(Game::class);
        $game = $gameRepository->find($id);
        
        $entityManager->remove($game);
        $entityManager->flush();
        
        return $this->redirectTo("/game");
    }
}
