<?php
include "../../include/layout/header.php";

?>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar Section -->
                <?php
                include "../../include/layout/sidebar.php"
                ?>

                <!-- Main Section -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
                    >
                        <h1 class="fs-3 fw-bold">ایجاد مقاله</h1>
                    </div>

                    <!-- Create Posts -->
                    <?php
                    $categories = $db->query("SELECT * FROM categories");

                    $invalidInsertTitle = '';
                    $invalidInsertAuthor = '';
                    $invalidInsertBody = '';
                    $invalidInsertImage = '';
                    $message = '';

                    if (isset($_POST['postCreate'])){

                        if (empty(trim($_POST['title']))){
                            $invalidInsertTitle = 'فیلد عنوان مقاله الزامی است';
                        }

                        if (empty(trim($_POST['author']))){
                            $invalidInsertAuthor = 'فیلد نویسنده مقاله الزامی است';
                        }

                        if (empty(trim($_FILES['image']['name']))){
                            $invalidInsertImage = 'فیلد عکس مقاله الزامی است';
                        }

                        if (empty(trim($_POST['body']))){
                            $invalidInsertBody = 'فیلد متن مقاله الزامی است';
                        }

                        if (!empty(trim($_POST['title'])) && !empty(trim($_POST['author'])) && !empty(trim($_FILES['image']['name'])) && !empty(trim($_POST['body']))){
                            $title = $_POST['title'];
                            $author = $_POST['author'];
                            $body =$_POST['body'];
                            $categoryId = $_POST['categoryId'];

                            $fileName = time() . "_" . $_FILES['image']['name'];
                            $tmpName = $_FILES['image']['tmp_name'];

                            if (move_uploaded_file($tmpName, "../../../uploads/posts/$fileName")) {
                                $postInsert = $db->prepare("INSERT INTO posts (title, author, category_id, image, body) VALUES (:title, :author, :category_id, :image, :body)");
                                $postInsert->execute(['title' => $title, 'author' => $author, 'category_id' => $categoryId, 'image' => $fileName, 'body' => $body,]);

                                header("Location:index.php");
//                                $message = 'مقاله با موفقیت ایجاد شد .';
                                exit();

                            }else{
                                echo 'Created post Error';
                            }
                        }

                    }
                    ?>
                    <?php if (isset($_POST['postCreate'])): ?>
                    <div class="text-success"><?= $message ?></div>
                    <?php endif; ?>
                    <div class="mt-4">
                        <form method="POST" class="row g-4" enctype="multipart/form-data">
                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">عنوان مقاله</label>
                                <input type="text" name="title" class="form-control" />
                                <div class="text-danger"><?= $invalidInsertTitle ?></div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">نویسنده مقاله</label>
                                <input type="text" name="author" class="form-control" />
                                <div class="text-danger"><?= $invalidInsertAuthor ?></div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label"
                                    >دسته بندی مقاله</label
                                >
                                <select class="form-select" name="categoryId">
                                    <?php if ($categories->rowCount() > 0): ?>
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="formFile" class="form-label"
                                    >تصویر مقاله</label
                                >
                                <input class="form-control" name="image" type="file" />
                                <div class="text-danger"><?= $invalidInsertImage ?></div>
                            </div>

                            <div class="col-12">
                                <label for="formFile" class="form-label">متن مقاله</label>
                                <textarea class="form-control" name="body" rows="6"></textarea>
                                <div class="text-danger"><?= $invalidInsertBody ?></div>
                            </div>

                            <div class="col-12">
                                <button type="submit" name="postCreate" class="btn btn-dark">
                                     ایجاد
                                </button>
                            </div>
                        </form>
                    </div>
                </main>
            </div>
        </div>

<?php
include "../../include/layout/footer.php"
?>
