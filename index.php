<?php include __DIR__ . '/template/header.php'; ?>
<?php 

    // Default Message
    $message = '';

    // Process Form
    if( array_key_exists('submit', $_POST) ) {

        try {

            if( empty($_POST['username']) ) { throw new Exception('Username is required'); }
            if( empty($_POST['password']) ) { throw new Exception('Password is required'); }

            // Fetch user 
            $user = new User();
            $info = $user->findUsername( $_POST['username'] );

            // Throw error if no user found
            if( empty($info) ) {
                throw new Exception("User not found");
            }

            // Validate Password
            if( $info['password'] != makeHash($_POST['password'], $info['salt']) ) {
                throw new Exception("Invalid password");
            }

            // Remove password and salt
            unset($info['password']);
            unset($info['salt']);

            echo '<pre>'; print_r($info); echo '</pre>';

            // Create a session for user
            $_SESSION[$config['app']['session_id']] = $info;

            redirectTo('home.php');

        }
        catch( Exception $e ) {
            $message = $e->getMessage();
        }

    }

?>

<div class="container">

    <h1><?php echo $config['app']['name']; ?></h1>

    <div class="row">
        <div class="col-md-3">

            <form action="index.php" method="post">

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?php echo old('username'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <p><?php echo $message; ?></p>

                <button type="submit" name="submit" class="btn btn-success">Login</button>

            </form>
        
        </div>
</div>
</div>


<?php include __DIR__ . '/template/footer.php'; ?>