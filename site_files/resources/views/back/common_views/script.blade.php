<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h2>Stacked form</h2>
        <form action="http://localhost:8000/adminmedia/run_script?id=754">
            <div class="mb-2">
                <label for="url">URL:</label>
                <input type="text" class="form-control" id="url" placeholder="Enter URL" name="url">
            </div>
            <div class="mb-2">
                <label for="url">Module ID:</label>
                <input type="number" class="form-control" id="mod_id" placeholder="Enter mod_id" name="mod_id"
                    value="33">
            </div>
            <div class="mb-2">
                <label for="id">ID:</label>
                <input type="text" class="form-control" id="id" placeholder="Enter ID" name="id">
            </div>
            <div class="mb-2 form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember"> Remember me
                </label>
            </div>
            <button type="submit"  class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>
