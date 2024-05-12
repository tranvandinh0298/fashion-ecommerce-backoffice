<?php

namespace App\Services;

use App\Exceptions\RestException;
use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Traits\DisplayHtmlTrait;
use App\Traits\LogTrait;
use App\Traits\ProcessingDataTrait;
use App\Traits\RequestToCoreTrait;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class OrderService
{
    use ProcessingDataTrait;
    use DisplayHtmlTrait;

    protected $orderRepository;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
    }

    public function getAllOrders()
    {
        $requestData = $this->getFilterData();

        $data = $this->orderRepository->getAllOrders($requestData);

        if (empty($data)) {
            $data = [
                "content" => [],
                "page" => [
                    "size" => $requestData['size'],
                    "totalElements" => 0,
                    "totalPages" => 0,
                    "number" => 0
                ],
            ];
        }

        $content = $data['content'];
        $data['content'] = $this->convertListOfOrdersToHTML($content);

        return $data;
    }

    public function getAllOrdersWithoutPagination($requestData)
    {
        $data = $this->orderRepository->getAllOrdersWithoutPagination($requestData);

        $data = $this->convertListOfOrderDTOs($data);

        return $data;
    }

    public function getOrderById($orderId)
    {
        $data = $this->orderRepository->getOrderById($orderId);

        $data = $this->convertListOfOrderDTOs($data);

        return $data;
    }

    public function createOrder(array $insertData)
    {
        $data = $this->orderRepository->createOrder($insertData);

        return $data;
    }

    public function updateOrder(int $orderId, array $updateData)
    {
        $data = $this->orderRepository->updateOrder($orderId, $updateData);

        return $data;
    }

    public function softDeleteOrder(int $orderId)
    {
        $data = $this->orderRepository->softDeleteOrder($orderId);

        return $data;
    }

    public function deleteOrder(int $id): bool
    {
        return true;
    }

    protected function convertListOfOrderDTOs($content)
    {
        if (!empty($content)) {
            $data = collect($content)->map(function ($order) {
                return $this->convertOrderDTOtoOrder($order);
            });
            return $data;
        }
    }

    protected function convertOrderDTOtoOrder($orderDTO)
    {
        return [
            'orderId' => $orderDTO['orderId'],
            'orderNumber' => $orderDTO['orderNumber'],
            'user' => $orderDTO['userDTO'],
            'subTotal' => $orderDTO['subTotal'],
            'shipping' => $orderDTO['shippingDTO'],
            'coupon' => $orderDTO['coupon'],
            'totalAmount' => $orderDTO['totalAmount'],
            'quantity' => $orderDTO['quantity'],
            'paymentMethod' => $orderDTO['paymentMethodDTO'],
            'paymentStatus' => $orderDTO['paymentStatus'],
            'photo' => url($orderDTO['photo']),
            'status' => $orderDTO['status'],
            'firstName' => $orderDTO['firstName'],
            'lastName' => $orderDTO['lastName'],
            'email' => $orderDTO['email'],
            'phone' => $orderDTO['phone'],
            'country' => $orderDTO['postCode'],
            'address1' => $orderDTO['address1'],
            'address2' => $orderDTO['address2'],
        ];
    }

    protected function convertListOfOrdersToHTML($orders)
    {
        if (!empty($orders)) {
            $data = collect($orders)->map(function ($order) {
                return $this->convertOrderToHTML($this->convertOrderDTOtoOrder($order));
            });
            return $data;
        }
    }

    protected function convertOrderToHTML($order)
    {
        $order['photo'] = $this->displayPhoto($order['photo']);
        $order['status'] = $this->displayOrderStatus($order['status']);
        $order['action'] = $this->displayShowButton($order['orderId'], 'orders') . $this->displayAction($order['orderId'], 'orders');

        return $order;
    }
}
