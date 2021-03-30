<?php
    $tmplJson = file_get_contents("resources/tmpl-params.json", "w");
    $rawJson = file_get_contents("params.json", "w");

    if (isset($_POST['clear'])) {
        file_put_contents('params.json', $tmplJson);
        header("Location: ..?message=The data has been cleaned up!");
    }

    $json = json_decode($rawJson, true);
    $thankyou_url = $json['thankyou_url'];
    $caid = $json['caid'];
    $pixel = htmlentities(str_replace('"', "'", $json['pixel']), ENT_COMPAT,'ISO-8859-1', true);
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="favicon.ico">

        <title>VLSerator</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="resources/writer.css">

    </head>

    <body>

        <?php if (isset($_GET["message"])): ?>
            <div class="alert alert-success" role="alert">
              <?php echo $_GET["message"] ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        <?php endif; ?>

        <main class="container pt-5 pb-5">
            <div class="row">
                <div class="col-12 mx-auto">
                  <?php if ($caid): ?>
                    <div class="mb-3">The following URL: https://www.pixelrte.com/track/<mark><?php echo $caid; ?></mark> will route to your thank you url below.</div>
                  <?php endif; ?>
                	<h3>Pixel Writer</h3>
                	<hr>
                    <form action="resources/write-file.php" method="post">
                      <div class="form-group">
                        <label for="thankyou_url">Thank you URL</label>
                        <input type="text" class="form-control" id="thankyou_url" name="thankyou_url" placeholder="https://www.test.com/thankyou.php" value="<?php echo $thankyou_url; ?>" required>
                        <small>Use <mark>https://</mark> for thank you pages</small>
                      </div>                     
                      <div class="form-group">
                        <label for="pixel_code">Pixel Code</label>
                        <textarea class="form-control" id="pixel_code" name="pixel_code" rows="5" placeholder="Traffic Source Pixel Code (noscript img tag if possible)" required><?php echo $pixel; ?></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary mb-2">Submit</button>
                        <?php if ($rawJson !== $tmplJson): ?>
                        <button type="submit" name="clear" class="btn btn-danger mb-2">Clear</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </main>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"   integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="   crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>    
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        
        <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>

    </body>
</html>