<?php
include_once("./database/connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body class="bg-light">
    <div class="container bg-dark text-light p-3 rounded my-4">
        <div class="d-flex align-items-center justify-content-between px-3">
            <h2><a href="insert.php" class="text-white text-decoration-none"><i class="bi bi-yelp"></i>Thêm mới</a> </h2>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="bi bi-plus-lg"></i> Thêm mới
            </button>
        </div>
    </div>
    <!-- Modal -->
    <div class="container mt-5 p-0">
        <table class="table table-hover text-center">
            <thead class="bg-dark text-light">
                <tr>
                    <th with='10%'scope="col" class="rounded-start">Id</th>
                    <th with='15%' scope="col">Tên</th>
                    <th with='10%'scope="col">Giá</th>
                    <th with='10%'scope="col">Số lượng</th>
                    <th with='35%'scope="col">Hình ảnh</th>
                    <th with='20%'scope="col" class="rounded-end">Thao tác</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
            </tbody>
        </table>

    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
        <form action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="name">Tên</span>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    

                    <div class="input-group mb-3">
                        <span class="input-group-text">Giá</span>
                        <input type="text" class="form-control" name="price" min="1" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Số lượng</span>
                        <input type="text" class="form-control" name="price" min="1" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Mô tả</span>
                        <textarea class="form-control" name="description" required></textarea>
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-select" id="inputGroupSelect02">
                            <option selected>Choose...</option>
                            <option value="1">Điện thoại</option>
                            <option value="2">Laptop</option>
                            <option value="3">Phụ kiện</option>
                        </select>
                        <label class="input-group-text" for="inputGroupSelect02">Options</label>
                    </div>

                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupFile01">Image</label>
                        <input type="file" class="form-control" name="image" accept=".jpg,.png,.svg" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
            
        </div>
    </div>
      </form>
</body>

</html>