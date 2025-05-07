<?php
/**
 * @OA\Get(
 *     path="/orders",
 *     tags={"orders"},
 *     summary="Get all orders",
 *     @OA\Response(
 *         response=200,
 *         description="Array of all orders in the database"
 *     )
 * )
 */
Flight::route('GET /orders', function() {
    $orders = Flight::ordersService()->get_all_orders();  // Updated method call
    Flight::json($orders);
});


/**
 * @OA\Get(
 *     path="/orders/{id}",
 *     tags={"orders"},
 *     summary="Get order by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the order",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the order with the given ID"
 *     )
 * )
 */
Flight::route('GET /orders/@id', function($id) {
    Flight::json(Flight::ordersService()->get_order_by_id($id));
});

/**
 * @OA\Post(
 *     path="/orders",
 *     tags={"orders"},
 *     summary="Add a new order",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "total_price"},
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="total_price", type="number", example=100.00),
 *             @OA\Property(property="status", type="string", example="pending")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New order created"
 *     )
 * )
 */
Flight::route('POST /orders', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::ordersService()->create_order($data));
});

/**
 * @OA\Put(
 *     path="/orders/{id}",
 *     tags={"orders"},
 *     summary="Update an existing order by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"status"},
 *             @OA\Property(property="status", type="string", example="shipped")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order updated"
 *     )
 * )
 */
Flight::route('PUT /orders/@id', function($id) {
    $data = Flight::request()->data->getData();  // Get request data
    $status = isset($data['status']) ? $data['status'] : null;
    
    if ($status) {
        Flight::ordersService()->update_order_status($id, $status);  // Pass the status as a string
        Flight::json(['message' => 'Order status updated successfully']);
    } else {
        Flight::halt(400, json_encode(['message' => 'Status is required']));
    }
});

/**
 * @OA\Delete(
 *     path="/orders/{id}",
 *     tags={"orders"},
 *     summary="Delete an order by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order deleted"
 *     )
 * )
 */
Flight::route('DELETE /orders/@id', function($id) {
    Flight::json(Flight::ordersService()->delete_order($id));
});
?>
