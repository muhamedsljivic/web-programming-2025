<?php
/**
 * @OA\Get(
 *     path="/cart/{user_id}",
 *     tags={"cart"},
 *     summary="Get the cart for a user",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the cart for the user"
 *     )
 * )
 */
Flight::route('GET /cart/@user_id', function($user_id) {
    Flight::json(Flight::cartService()->get_cart_by_user_id($user_id));  // Correct method name
});


/**
 * @OA\Post(
 *     path="/cart/{user_id}",
 *     tags={"cart"},
 *     summary="Add a product to the cart",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"product_id", "quantity"},
 *             @OA\Property(property="product_id", type="integer", example=1),
 *             @OA\Property(property="quantity", type="integer", example=2)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product added to cart"
 *     )
 * )
 */
Flight::route('POST /cart/@user_id', function($user_id) {
    $data = Flight::request()->data->getData();
    // Assuming 'product_id' and 'quantity' are the keys in the request body
    $product_id = isset($data['product_id']) ? $data['product_id'] : null;
    $quantity = isset($data['quantity']) ? $data['quantity'] : 1;

    // Pass individual values instead of the whole $data array
    if ($product_id) {
        Flight::json(Flight::cartService()->add_to_cart($user_id, $product_id, $quantity));
    } else {
        Flight::halt(400, json_encode(['message' => 'Product ID is required']));
    }
});

/**
 * @OA\Delete(
 *     path="/cart/{user_id}/{product_id}",
 *     tags={"cart"},
 *     summary="Remove a product from the cart",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Parameter(
 *         name="product_id",
 *         in="path",
 *         required=true,
 *         description="ID of the product to remove",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product removed from cart"
 *     )
 * )
 */
Flight::route('DELETE /cart/@user_id/@product_id', function($user_id, $product_id) {
    Flight::json(Flight::cartService()->remove_from_cart($user_id, $product_id));
});
?>
