<?php

namespace Core\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use Core\Application\Payment\Commands\CreatePaymentCommand;
use Core\Application\Payment\Handlers\CreatePaymentHandler;
use Core\Domain\Payment\PaymentRepositoryInterface;
use Core\Infrastructure\Exceptions\GatewayException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(title="API Documentation", version="1.0")
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class PaymentController extends Controller
{
    protected $paymentRepository;
    protected $createPaymentHandler;

    public function __construct(PaymentRepositoryInterface $paymentRepository, CreatePaymentHandler $createPaymentHandler)
    {
        $this->paymentRepository = $paymentRepository;
        $this->createPaymentHandler = $createPaymentHandler;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/payments",
     *     summary="List all payments",
     *     tags={"Payments"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="List of payments"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function index()
    {
        return $this->paymentRepository->findAll();
    }

    /**
     * @OA\Get(
     *     path="/api/v1/payments/{id}",
     *     summary="Get details of a specific payment",
     *     tags={"Payments"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Payment details"),
     *     @OA\Response(response=404, description="Payment not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function show($id)
    {
        return $this->paymentRepository->findById($id);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/payments",
     *     summary="Create a new payment",
     *     tags={"Payments"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name_client", type="string", example="Jane Doe"),
     *             @OA\Property(property="cpf", type="string", example="12345678909"),
     *             @OA\Property(property="description", type="string", example="Payment for services"),
     *             @OA\Property(property="amount", type="number", format="float", example=150.00),
     *             @OA\Property(property="payment_method", type="string", example="pix")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Payment created"),
     *     @OA\Response(response=400, description="Bad request")
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_client' => 'required|string',
            'cpf' => 'required|string',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string|exists:payment_methods,slug'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $command = new CreatePaymentCommand(
            $request->name_client,
            $request->cpf,
            $request->description,
            $request->amount,
            $request->payment_method
        );

        try {
            $payment = $this->createPaymentHandler->handle($command);
        } catch (GatewayException $exception) {
            return response()->json($exception->getMessage(), $exception->getCode());
        }

        return response()->json($payment, 201);
    }
}
