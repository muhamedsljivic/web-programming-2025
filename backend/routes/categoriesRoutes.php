<?php
/**
 * @OA\Get(
 *     path="/categories",
 *     tags={"categories"},
 *     summary="Get all categories",
 *     @OA\Response(
 *         response=200,
 *         description="Array of all categories in the database"
 *     )
 * )
 */
Flight::route('GET /categories', function() {
    Flight::json(Flight::categoriesService()->get_all_categories());
});

/**
 * @OA\Get(
 *     path="/categories/{id}",
 *     tags={"categories"},
 *     summary="Get category by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the category",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the category with the given ID"
 *     )
 * )
 */
Flight::route('GET /categories/@id', function($id) {
    Flight::json(Flight::categoriesService()->get_category_by_id($id));
});

/**
 * @OA\Post(
 *     path="/categories",
 *     tags={"categories"},
 *     summary="Add a new category",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Pizza")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New category created"
 *     )
 * )
 */
Flight::route('POST /categories', function() {
    try {
        $data = Flight::request()->data->getData();
        Flight::json(Flight::categoriesService()->create_category($data));
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400); // Return error with status 400 for bad request
    }
});

/**
 * @OA\Put(
 *     path="/categories/{id}",
 *     tags={"categories"},
 *     summary="Update an existing category by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Updated Pizza")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category updated"
 *     )
 * )
 */
Flight::route('PUT /categories/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::categoriesService()->update_category($id, $data));
});

/**
 * @OA\Delete(
 *     path="/categories/{id}",
 *     tags={"categories"},
 *     summary="Delete a category by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category deleted"
 *     )
 * )
 */
Flight::route('DELETE /categories/@id', function($id) {
    Flight::json(Flight::categoriesService()->delete_category($id));
});
?>
