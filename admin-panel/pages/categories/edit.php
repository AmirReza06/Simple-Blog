<?php
include "../../include/layout/header.php";

$invalidInsertTitle = '';

if (isset($_GET['id'])){
    $categoryId = $_GET['id'];
    $categories = $db->prepare("SELECT * FROM categories WHERE id = :id");
    $categories->execute(['id' => $categoryId]);
    $categories = $categories->fetch();

    if (isset($_POST['editCategory'])){
        if (empty(trim($_POST['title']))){
            $invalidInsertTitle = 'فیلد عنوان دسته بندی الزامی است';
        }

        if (!empty(trim($_POST['title']))){
            $title = $_POST['title'];

            $editCategory = $db->prepare("UPDATE categories SET title=:title WHERE id = :id");
            $editCategory->execute(['title' => $title, 'id' => $categoryId]);

            header("Location:index.php");
            exit();
        }
    }



}




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
                        <h1 class="fs-3 fw-bold">ویرایش دسته بندی</h1>
                    </div>

                    <!-- Posts -->
                    <div class="mt-4">
                        <form method="POST" class="row g-4">
                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">عنوان دسته بندی</label>
                                <input type="text" name="title" class="form-control" value="<?= $categories['title'] ?>" />
                                <div class="text-danger"><?= $invalidInsertTitle ?></div>
                            </div>

                            <div class="col-12">
                                <button type="submit" name="editCategory" class="btn btn-dark">
                                     ویرایش
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