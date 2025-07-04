<?php

namespace App\Controller;

use App\Dto\TransacaoRealizarDto;
use App\Entity\Transacao;
use App\Repository\ContaRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
final class TransacoesController extends AbstractController
{
    #[Route('/transacoes', name: 'transacoes_realizar', methods: ['POST'])]
    public function irealizar(
        #[MapRequestPayload(acceptFormat: 'json')]
        TransacaoRealizarDto $entrada,
        ContaRepository $contaRepository,
        EntityManagerInterface $entityManager
    ): Response | JsonResponse
    {

        //VALIDAÇÕES DE ENTRADA
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

        //VALIDAÇÕES DE NEGOCIO
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

        //Validar se a origem tem saldo suficiente
        if ((float) $entrada->getValor() > (float) $contaOrigem->getSaldo() ) {
            return $this->json([
                'message' => 'O valor ultrapassa seu saldo disponível'
            ], 404);
        }


        //realizar a transação e salvar no banco
        $saldo = (float) $contaOrigem->getSaldo();
        $valorT = (float) $entrada->getValor();
        $saldoDestino = (float) $contaDestino->getSaldo();

        $contaOrigem->setSaldo($saldo - $valorT);
        $entityManager->persist($contaOrigem);

        $contaDestino->setSaldo($valorT + $saldoDestino);
        $entityManager->persist($contaDestino);

        //Registrar a transação
        $transacao = new Transacao();
        $transacao->setDataHora(new DateTime());
        $transacao->setValor($entrada->getValor()); 
        $transacao->setContaOrigem($contaOrigem);
        $transacao->setContaDestino($contaDestino);
        $entityManager->persist($transacao);

        $entityManager->flush();

        return new Response(status: 204);

        


        //3. validar se a origem tem saldo suficientte
    }
}