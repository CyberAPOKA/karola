<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\RaffleNumber;
use GuzzleHttp\Client;

class PaymentController extends Controller
{
    public function confirmPayment($orderId)
    {
        $order = Order::findOrFail($orderId);
        $raffle = $order->raffle;
        $totalCoupons = $order->total_coupons;
        $generatedNumbers = [];

        // Gerar números únicos de rifa
        for ($i = 0; $i < $totalCoupons; $i++) {
            do {
                $number = rand(100000, 999999);
            } while (RaffleNumber::where('raffle_id', $raffle->id)->where('number', $number)->exists());

            RaffleNumber::create([
                'raffle_id' => $raffle->id,
                'order_id' => $order->id,
                'number' => $number,
            ]);

            $generatedNumbers[] = $number;
        }

        // Retorne ou processe conforme necessário
        return response()->json(['numbers' => $generatedNumbers], 200);
    }

    public function simulatePayment(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Configurar a API do Pagar.me
        $client = new Client([
            'base_uri' => 'https://api.pagar.me/core/v5/',
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(env('PAGARME_API_KEY') . ':'),
                'Content-Type' => 'application/json'
            ]
        ]);

        // Obter o ID da cobrança PIX (charge_id)
        $chargeId = $order->code; // Ajuste para pegar o ID correto da cobrança

        // Simular o pagamento PIX
        try {
            $response = $client->post("charges/{$chargeId}/capture", [
                'json' => [
                    'amount' => intval($order->total_price * 100),
                ]
            ]);

            $simulationResult = json_decode($response->getBody()->getContents(), true);

            // Atualizar o status do pedido
            $order->update([
                'status' => 'paid'
            ]);

            return response()->json(['message' => 'Payment simulated successfully!', 'order' => $order], 200);
        } catch (\Exception $e) {
            // Tratar o erro, registrar logs ou retornar uma resposta de erro
            return response()->json(['message' => 'Error simulating payment: ' . $e->getMessage()], 500);
        }
    }
}
