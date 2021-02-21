<?php
namespace App\Controller;


use App\FakeData;
use App\Entity\Player;
use App\Entity\Game;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class PlayerController extends AbstractController
{
    /**
     * Retourne la page des joueurs
     * 
     * @param Request                   $request
     * @param EntityManagerInterface    $entityManager
     * 
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $playerRepository = $entityManager->getRepository(Player::class);
        $players = $playerRepository->findAll();
        
        return $this->render("player/index", ["players" => $players]);

    }


    /**
     * Ajoute un nouveau joueur
     * 
     * @param Request                   $request
     * @param EntityManagerInterface    $entityManager
     * 
     * @return Response
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fakePlayer = FakeData::players(1)[0];
        $fakeUsername = $fakePlayer["username"];
        $fakeEmail = $fakePlayer["email"];

        $player = new Player();
        $player->setUsername($fakeUsername);
        $player->setEmail($fakeEmail);

        if ($request->getMethod() == Request::METHOD_POST) {
            $player->setUsername($request->get("username"));
            $player->setEmail($request->get("email"));

            $entityManager->persist($player);
            $entityManager->flush();

            return $this->redirectTo("/player");
        }

        return $this->render("player/form", ["player" => $player]);
    }


    /**
     * Affiche les détails d'un joueur
     * 
     * @param                           $id
     * @param EntityManagerInterface    $entityManager
     * 
     * @return Response
     */
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $playerRepository = $entityManager->getRepository(Player::class);
        $player = $playerRepository->find($id);

        return $this->render("player/show", ["player" => $player, "availableGames" => FakeData::games()]);
    }


    /**
     * Modifie un joueur
     * 
     * @param                           $id
     * @param Request                   $request
     * @param EntityManagerInterface    $entityManager
     * 
     * @return Response
     */
    public function edit($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $playerRepository = $entityManager->getRepository(Player::class);
        $player = $playerRepository->find($id);

        if ($request->getMethod() == Request::METHOD_POST) {
            $player->setUsername($request->get("username"));
            $player->setEmail($request->get("email"));

            $entityManager->persist($player);
            $entityManager->flush();

            return $this->redirectTo("/player");
        }

        return $this->render("player/form", ["player" => $player]);
    }


    /**
     * Supprime un joueur
     * 
     * @param                           $id
     * @param EntityManagerInterface    $entityManager
     * 
     * @return Response
     */
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $playerRepository = $entityManager->getRepository(Player::class);
        $player = $playerRepository->find($id);

        $entityManager->remove($player);
        $entityManager->flush();
        
        return $this->redirectTo("/player");

    }

    /**
     * Ajoute un jeu
     * 
     * @param                           $userId
     * @param                           $gameId
     * @param Request                   $request
     * @param EntityManagerInterface    $entityManager
     * 
     * @return Response
     */
    public function addgame($userId, $gameId, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->getMethod() == Request::METHOD_POST) {
            $playerRepository = $entityManager->getRepository(Player::class);
            $player = $playerRepository->find($userId);

            $gameRepository = $entityManager->getRepository(Game::class);
            $game = $gameRepository->find($gameId);

            $player->addGame($game);

            $entityManager->persist($player);
            $entityManager->flush();

            return $this->redirectTo("/player");
        }
    }
}
