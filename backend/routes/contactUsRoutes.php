<?php
/**
 * @OA\Get(
 *     path="/contactus",
 *     tags={"contactus"},
 *     summary="Get all contact us messages",
 *     @OA\Response(
 *         response=200,
 *         description="Array of all contact messages"
 *     )
 * )
 */
Flight::route('GET /contactus', function() {
    // Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::contactUsService()->get_all_messages());
});

/**
 * @OA\Get(
 *     path="/contactus/{id}",
 *     tags={"contactus"},
 *     summary="Get contact message by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the contact message",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the contact message with the given ID"
 *     )
 * )
 */
Flight::route('GET /contactus/@id', function($id) {
    Flight::json(Flight::contactUsService()->get_message_by_id($id));
});

/**
 * @OA\Post(
 *     path="/contactus",
 *     tags={"contactus"},
 *     summary="Submit a contact us message",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "message"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="message", type="string", example="I have a question about your service.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Contact message submitted"
 *     )
 * )
 */
Flight::route('POST /contactus', function() {
    $data = Flight::request()->data->getData();

    // Log incoming data for debugging
    error_log(print_r($data, true)); // Log the request data to the PHP error log

    $user_id = isset($data['user_id']) ? $data['user_id'] : null;
    $name = isset($data['name']) ? $data['name'] : null;
    $email = isset($data['email']) ? $data['email'] : null;
    $message = isset($data['message']) ? $data['message'] : null;

    // Check if required fields are present
    if (empty($name) || empty($email) || empty($message)) {
        Flight::json(['error' => 'Name, email, and message are required'], 400);
        return;
    }

    // Call the service method with individual arguments
    $response = Flight::contactUsService()->submit_message($user_id, $name, $email, $message);

    // Respond with the result
    Flight::json($response);
});



/**
 * @OA\Delete(
 *     path="/contactus/{id}",
 *     tags={"contactus"},
 *     summary="Delete a contact us message by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Contact message ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Contact message deleted"
 *     )
 * )
 */
Flight::route('DELETE /contactus/@id', function($id) {
    Flight::json(Flight::contactUsService()->delete_message($id));
});
?>
