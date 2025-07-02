<?php

namespace App\Controller;

use App\Dto\TransacaoRealizarDto;
use App\Repository\ContaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
final class TransacoesController extends AbstractController
{
    #[Route('/transacoes', name: 'transacoes_realizar', methods: ['POST'])]
    public function irealizar(
        #[MapRequestPayload(acceptFormat: 'json')]
        TransacaoRealizarDto $entrada,
        ContaRepository $contaRepository
    ): JsonResponse
    {

        //1. Validar se a entrada tem id de origem / id de destino / valor
        $erros = [];
        if (!$entrada->getIdUsuarioOrigem()) {
            array_push($erros, [
                'message' => 'Informe a conta de Origem!'
            ]);
        }
        if (!$entrada->getIdUsuarioDestino()) {
            array_push($erros, [
                'message' => 'Informe a conta de Destino!'
            ]);
        }
        if (!$entrada->getValor() || (float) $entrada->getValor() <= 0) {
            array_push($erros, [
                'message' => 'Informe o valor da transação!'
            ]);
        }

        //2. Validar se as contas são iguais
        if($entrada->getIdUsuarioOrigem() === $entrada->getIdUsuarioDestino()) {
            array_push($erros, [
                'message' => 'A conta de destino não pode ser a mesma de origem!'
            ]);
        }

        if (count($erros) > 0) {
            return $this->json($erros, 422);
        }

        //3. Validar se as contas existem
        $contaOrigem = $contaRepository->findByUsuarioId($entrada->getIdUsuarioOrigem());
        if (!$contaOrigem) {
            return $this->json([
                'message' => 'Conta de origem não encontrada!'
            ], 404);
        }
        $contaDestino = $contaRepository->findByUsuarioId($entrada->getIdUsuarioDestino());
        if (!$contaDestino) {
            return $this->json([
                'message' => 'Conta de destino não encontrada!'
            ], 404);
        }


        return $this->json([
            'message' => 'Transação efetuada com sucesso!',
            'path' => 'src/Controller/TransacoesController.php',
        ]);

        


        //3. validar se a origem tem saldo suficientte
    }
}