<?php
/**
 * @OA\Get(
 *     path="/products",
 *     tags={"products"},
 *     summary="Get all products",
 *     @OA\Response(
 *         response=200,
 *         description="Array of all products in the database"
 *     )
 * )
 */
Flight::route('GET /products', function() {
    Flight::json(Flight::productsService()->get_all_products());
});

/**
 * @OA\Get(
 *     path="/products/{id}",
 *     tags={"products"},
 *     summary="Get product by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the product",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the product with the given ID"
 *     )
 * )
 */
Flight::route('GET /products/@id', function($id) {
    Flight::json(Flight::productsService()->get_product_by_id($id));
});

/**
 * @OA\Post(
 *     path="/products",
 *     tags={"products"},
 *     summary="Add a new product",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "price"},
 *             @OA\Property(property="name", type="string", example="Pizza Margherita"),
 *             @OA\Property(property="price", type="number", example=15.99),
 *             @OA\Property(property="category_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New product created"
 *     )
 * )
 */
Flight::route('POST /products', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::productsService()->create_product($data));
});

/**
 * @OA\Put(
 *     path="/products/{id}",
 *     tags={"products"},
 *     summary="Update an existing product by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "price"},
 *             @OA\Property(property="name", type="string", example="Updated Pizza"),
 *             @OA\Property(property="price", type="number", example=17.99),
 *             @OA\Property(property="category_id", type="integer", example=2)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product updated"
 *     )
 * )
 */
Flight::route('PUT /products/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::productsService()->update_product($id, $data));
});

/**
 * @OA\Delete(
 *     path="/products/{id}",
 *     tags={"products"},
 *     summary="Delete a product by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product deleted"
 *     )
 * )
 */
Flight::route('DELETE /products/@id', function($id) {
    Flight::json(Flight::productsService()->delete_product($id));
});
?>
