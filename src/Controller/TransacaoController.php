<?php

namespace App\Controller;

use App\Dto\TransacaoDto;
use App\Repository\TransacaoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
final class TransacaoController extends AbstractController
{
    #[Route('/transacao', name: 'transacao_enviar', methods: ['POST'])]
    public function depositar(
        #[MapRequestPayload(acceptFormat: 'json')]
        TransacaoDto $transacaoDto,
        EntityManagerInterface $entityManager,
        TransacaoRepository $transacaoRepository
    ): JsonResponse
    {
        if (empty($transacaoDto->getContaOrigem())) {
            return $this->json([
                'message' => 'Conta Inválida!'
            ], status: 404);
        };
    }
}
