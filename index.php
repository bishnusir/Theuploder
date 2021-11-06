
<!DOCTYPE html>
<!--
  Code by Pure Coding
  Website: https://akhfasoft.net/
  YouTube: https://youtube.com/PureCoding
-->
<html lang="en">
  <head>
    <style>
    @import url("https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: "Roboto", sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
  background: #0b79ea;
  min-height: 100vh;
}

.container {
  max-width: 400px;
  width: 100%;
  background: white;
  padding: 2rem;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
}

.container .title {
  font-size: 1.7rem;
  font-weight: 800;
  border-left: 0.3rem solid;
  padding-left: 0.5rem;
  color: #0b79ea;
  margin-bottom: 1rem;
  text-transform: uppercase;
  word-spacing: 4px;
}

.container .inputBox {
  margin-bottom: 1rem;
}

.container .inputBox:last-child {
  margin-bottom: 0;
}

.container .inputBox .form-label {
  display: block;
  font-weight: 500;
  font-size: 0.9rem;
  color: #222;
  margin-bottom: 0.3rem;
}

.container .inputBox .form-control {
  border: 1px solid #eee;
  width: 100%;
  min-height: 40px;
  padding: 1rem;
  font-size: 0.9rem;
  color: #222;
  outline: none;
  transition: 0.3s;
}

.container .inputBox .form-control:focus,
.container .inputBox .form-control:valid {
  border-color: #0b79ea;
}

.btn {
  border: none;
  outline: none;
  background: #0b79ea;
  padding: 0.7rem 2rem;
  color: white;
  font-weight: 500;
  font-size: 0.9rem;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
  text-decoration: none;
  cursor: pointer;
}

    </style>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Remote File upload in PHP - Pure Coding</title>
  </head>
  <body>
    <div class="container">
      <div class="remote-upload">
        <h2 class="title">Remote File Upload</h2>
        <?php if (isset($msg["success"])) { ?>
        <p style="color:green;margin-bottom: 1rem;"><?php echo $msg["success"]; ?></p>
        <?php } ?>
        <form action="" method="post">
          <div class="inputBox">
            <label for="file_url" class="form-label">File URL</label>
            <input
              type="text"
              id="file_url"
              class="form-control"
              name="file_url"
              placeholder="e.g. https://example.com/filename.zip"
              value="<?php if (isset($_POST["file_url"])) { echo $_POST["file_url"]; } ?>"
              required
            />
            <?php if (isset($msg["error"])) { ?>
            <small style="color:red;"><?php echo $msg["error"]; ?></small>
            <?php } ?>
          </div>
          <div class="inputBox">
            <label for="file_name" class="form-label">File Name</label>
            <input
              type="text"
              id="file_name"
              class="form-control"
              name="file_name"
              value="<?php if (isset($_POST["file_name"])) { echo $_POST["file_name"]; } ?>"
              placeholder="e.g. My File"
              required
            />
          </div>
          <div class="inputBox">
            <button class="btn" name="submit" type="submit">Upload Now!</button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
<?php
if (isset($_POST["submit"])) {
  $file_url = $_POST["file_url"];
  $file_name = $_POST["file_name"];

  if (filter_var($file_url, FILTER_VALIDATE_URL)) {
    $pathinfo = pathinfo($file_url);
    if (isset($pathinfo["extension"])) {
      $file_name .= "." . $pathinfo["extension"];
      $file_content = file_get_contents($file_url);
      $fopen = fopen("files/" . $file_name, "w");
      $fwrite = fwrite($fopen, $file_content);
      fclose($fopen);
      if ($fwrite) {
        $msg["success"] = "File Uploaded Successfully.";
        $_POST["file_url"] = "";
        $_POST["file_name"] = "";
      } else {
        $msg["error"] = "Something wrong went. Please try again.";
      }
    } else {
      $msg["error"] = "Please enter a file URL.";
    }
  } else {
    $msg["error"] = "Please enter a valid URL.";
  }
}
?>
