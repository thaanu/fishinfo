<?php include __DIR__ . '/template/header.php'; ?>
<?php 

    $message = '';

    // Process Form
    if( array_key_exists('submit', $_POST) ) {

        $message = 'Submitted';

    }

?>

<div class="container">

    <h1><?php echo $config['app']['name']; ?></h1>

    <div class="row">
        <div class="col-md-3">

            <form action="index.php" method="post">

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <p><?php echo $message; ?></p>

                <button type="submit" name="submit" class="btn btn-success">Login</button>

            </form>
        
        </div>
</div>
</div>


<?php include __DIR__ . '/template/footer.php'; ?>