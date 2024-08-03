<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Raffle;
use App\Models\Order;
use Inertia\Inertia;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function createOrder(Request $request, $id)
    {
        $user = Auth::user();
        $raffle = Raffle::findOrFail($id);

        // Calcula o preço total dos cupons comprados
        $totalPrice = ($request->amount_1_coupon * $raffle->price_1_coupon) + ($request->amount_100_coupons * $raffle->price_100_coupons * 100) + ($request->amount_250_coupons * $raffle->price_250_coupons * 250) + ($request->amount_500_coupons * $raffle->price_500_coupons * 500) + ($request->amount_1000_coupons * $raffle->price_1000_coupons * 1000) + ($request->amount_5000_coupons * $raffle->price_5000_coupons * 5000) + ($request->amount_10000_coupons * $raffle->price_10000_coupons * 10000);

        $totalPrice = round($totalPrice, 2); // Arredonda para duas casas decimais

        // Calcula o total de cupons comprados
        $totalCoupons = $request->amount_1_coupon + ($request->amount_100_coupons * 100) + ($request->amount_250_coupons * 250) + ($request->amount_500_coupons * 500) + ($request->amount_1000_coupons * 1000) + ($request->amount_5000_coupons * 5000) + ($request->amount_10000_coupons * 10000);

        $order = Order::create([
            'user_id' => $user->id,
            'raffle_id' => $raffle->id,
            'total_coupons' => $totalCoupons,
            'total_price' => $totalPrice,
            'amount_1_coupon' => $request->amount_1_coupon,
            'amount_100_coupons' => $request->amount_100_coupons,
            'amount_250_coupons' => $request->amount_250_coupons,
            'amount_500_coupons' => $request->amount_500_coupons,
            'amount_1000_coupons' => $request->amount_1000_coupons,
            'amount_5000_coupons' => $request->amount_5000_coupons,
            'amount_10000_coupons' => $request->amount_10000_coupons,
        ]);

        // Remover caracteres especiais do número de telefone
        $phone = preg_replace('/[^0-9]/', '', $user->phone);
        $areaCode = substr($phone, 0, 2);
        $number = substr($phone, 2);

        // Configurar a API do Pagar.me
        $client = new Client([
            'base_uri' => 'https://api.pagar.me/core/v5/',
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(env('PAGARME_API_KEY') . ':'),
                'Content-Type' => 'application/json'
            ],
            'verify' => storage_path('cacert.pem') // Caminho para o arquivo cacert.pem
        ]);

        $amountInCents = intval($totalPrice * 100); // Converter para centavos

        // Criar a requisição para o PIX
        try {
            $response = $client->post('orders', [
                'json' => [
                    'items' => [
                        [
                            'amount' => $amountInCents,
                            'description' => 'Participação na rifa ' . $raffle->title,
                            'quantity' => 1
                        ]
                    ],
                    'customer' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'type' => 'individual',
                        'document' => $user->cpf,
                        'phones' => [
                            'home_phone' => [
                                'country_code' => '55',
                                'number' => $number,
                                'area_code' => $areaCode
                            ]
                        ]
                    ],
                    'payments' => [
                        [
                            'payment_method' => 'pix',
                            'pix' => [
                                'expires_in' => '3600', // Expiração do código PIX em segundos (1 hora)
                                'additional_information' => [
                                    [
                                        'name' => 'Quantidade',
                                        'value' => '1'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]);

            $pixOrder = json_decode($response->getBody()->getContents(), true);
            Log::info($pixOrder);

            $expiresAt = (new \DateTime($pixOrder['charges'][0]['last_transaction']['expires_at']))->format('Y-m-d H:i:s');

            $order->update([
                'order_id' => $pixOrder['id'],
                'qr_code_url' => $pixOrder['charges'][0]['last_transaction']['qr_code_url'],
                'qr_code' => $pixOrder['charges'][0]['last_transaction']['qr_code'],
                'expires_at' => $expiresAt,
                'status' => $pixOrder['charges'][0]['last_transaction']['status'],
                'code' => $pixOrder['code'],
            ]);

            session(['pixOrder' => $pixOrder]);

            return redirect()->route('payment', $order->id)->with('order', $order);
        } catch (\Exception $e) {
            // Tratar o erro, registrar logs ou retornar uma resposta de erro
            return redirect()->back()->withErrors(['msg' => 'Erro ao criar o pedido PIX: ' . $e->getMessage()]);
        }
    }

    public function payment($id)
    {
        $order = Order::find($id);

        return Inertia::render('Payment', [
            'order' => $order,
            'pix_order' => session('pixOrder')
        ]);
    }
}
