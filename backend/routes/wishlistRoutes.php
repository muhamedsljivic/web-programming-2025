<?php
/**
 * @OA\Get(
 *     path="/wishlist/{user_id}",
 *     tags={"wishlist"},
 *     summary="Get wishlist for a user",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the wishlist for the user"
 *     )
 * )
 */
Flight::route('GET /wishlist/@user_id', function($user_id) {
    Flight::json(Flight::wishlistService()->get_wishlist_by_user_id($user_id));
});


/**
 * @OA\Post(
 *     path="/wishlist/{user_id}",
 *     tags={"wishlist"},
 *     summary="Add a product to the wishlist",
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
 *             required={"product_id"},
 *             @OA\Property(property="product_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product added to wishlist"
 *     )
 * )
 */
Flight::route('POST /wishlist/@user_id', function($user_id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::wishlistService()->add_to_wishlist($user_id, $data));
});

/**
 * @OA\Delete(
 *     path="/wishlist/{user_id}/{product_id}",
 *     tags={"wishlist"},
 *     summary="Remove a product from the wishlist",
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
 *         description="Product removed from wishlist"
 *     )
 * )
 */
Flight::route('DELETE /wishlist/@user_id/@product_id', function($user_id, $product_id) {
    Flight::json(Flight::wishlistService()->remove_from_wishlist($user_id, $product_id));
});
?>
