<?php
/**
 * @OA\Get(
 *      path="/users",
 *      tags={"users"},
 *      summary="Get all users",
 *      @OA\Response(
 *           response=200,
 *           description="Array of all users in the database"
 *      )
 * )
 */
Flight::route('GET /users', function() {
    AuthMiddleware::authorizeRole('admin');
    Flight::json(Flight::usersService()->get_all_users());
});

/**
 * @OA\Get(
 *     path="/users/{email}",
 *     tags={"users"},
 *     summary="Get user by email",
 *     @OA\Parameter(
 *         name="email",
 *         in="path",
 *         required=true,
 *         description="Email of the user",
 *         @OA\Schema(type="string", example="user@example.com")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the user with the given email"
 *     )
 * )
 */
Flight::route('GET /users/@email', function($email) {
    Flight::json(Flight::usersService()->get_user_by_email($email));
});
/**
 * @OA\Post(
 *     path="/users",
 *     tags={"users"},
 *     summary="Add a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", example="user@example.com"),
 *             @OA\Property(property="password", type="string", example="securepassword")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New user created"
 *     )
 * )
 */
Flight::route('POST /users', function() {
    $data = Flight::request()->data->getData();
    
    $name = $data['name'];
    $email = $data['email'];
    $password = $data['password'];  // Assume password is already hashed
    $phone = $data['phone'];
    $address = $data['address'];
    $city = $data['city'];
    $country = $data['country'];
    $postal_code = $data['postal_code'];
    $role = $data['role'];
    $created_at = $data['created_at'];

    Flight::json(Flight::usersService()->create_user($name, $email, $password, $phone, $address, $city, $country, $postal_code, $role, $created_at));
});


/**
 * @OA\Put(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Update an existing user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email"},
 *             @OA\Property(property="email", type="string", example="updated@example.com"),
 *             @OA\Property(property="password", type="string", example="newpassword")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated"
 *     )
 * )
 */
Flight::route('PUT /users/@id', function($id) {
    // Log the incoming request data
    $data = Flight::request()->data->getData();

    // Proceed with updating the user
    $result = Flight::usersService()->update_user($id, $data);
    Flight::json($result);
});





/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Delete a user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted"
 *     )
 * )
 */
Flight::route('DELETE /users/@id', function($id) {
    Flight::json(Flight::usersService()->delete_user($id));
});

/**
 * @OA\Post(
 *     path="/register",
 *     tags={"auth"},
 *     summary="Register a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "username", "password"},
 *             @OA\Property(property="username", type="string", example="JohnDoe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="password", type="string", example="SecurePass123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User registered successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Missing required fields"
 *     ),
 *     @OA\Response(
 *         response=409,
 *         description="User already exists"
 *     )
 * )
 */

// Register a new user
Flight::route('POST /register', function() {
    $data = Flight::request()->data->getData();

    if (!isset($data['email'], $data['password'], $data['username'])) {
        Flight::halt(400, 'Missing required fields');
    }

    $existing = Flight::usersService()->get_user_by_email($data['email']);
    if ($existing) {
        Flight::halt(409, 'User already exists');
    }

    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    $data['role'] = 'user'; // default role

    Flight::usersService()->add_user($data);
    Flight::json(['message' => 'User registered successfully']);
});

/**
 * @OA\Post(
 *     path="/login",
 *     tags={"auth"},
 *     summary="Login a user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="password", type="string", example="SecurePass123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login successful"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Invalid credentials"
 *     )
 * )
 */

// Login
Flight::route('POST /login', function() {
    $data = Flight::request()->data->getData();

    if (!isset($data['email'], $data['password'])) {
        Flight::halt(400, 'Missing email or password');
    }

    $user = Flight::usersService()->get_user_by_email($data['email']);

    if (!$user || !password_verify($data['password'], $user['password'])) {
        Flight::halt(401, 'Invalid credentials');
    }

    // Save user session
    session_start();
    $_SESSION['user'] = [
        'id' => $user['id'],
        'email' => $user['email'],
        'role' => $user['role']
    ];

    Flight::json(['message' => 'Login successful']);
});

?>
