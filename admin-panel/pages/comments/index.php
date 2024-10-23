<?php
include "../../include/layout/header.php";

$comments = $db->query("SELECT * FROM comments ORDER BY id DESC");

if ( isset($_GET['action']) && isset($_GET['id'])){
    $action = $_GET['action'];
    $id = $_GET['id'];

    if ($action == 'delete'){
        $query = $db->prepare("DELETE FROM comments WHERE id = :id");
    }elseif ($action == 'approve'){
        $query = $db->prepare("UPDATE comments SET status = 1 WHERE id = :id");
    }

    $query->execute(['id' => $id]);

    header("Location:index.php");
    exit();

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
                        <h1 class="fs-3 fw-bold">کامنت ها</h1>
                    </div>

                    <!-- Comments -->
                    <div class="mt-4">
                        <div class="table-responsive small">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>نام</th>
                                        <th>متن کامنت</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if ($comments->rowCount() > 0): ?>
                                <?php foreach ($comments as $comment): ?>
                                    <tr>
                                        <th><?= $comment['id'] ?></th>
                                        <td><?= $comment['name'] ?></td>
                                        <td>
                                            <?= $comment['comment'] ?>
                                        </td>
                                        <td>
                                            <?php if ($comment['status'] == 1): ?>
                                            <a href="#" class="btn btn-sm btn-outline-dark disabled">تایید شده</a>
                                            <?php else: ?>
                                            <a href="index.php?action=approve&id=<?= $comment['id'] ?>" class="btn btn-sm btn-outline-primary">در انتظار تایید</a>
                                            <?PHP endif; ?>
                                            <a href="index.php?action=delete&id=<?= $comment['id'] ?>" class="btn btn-sm btn-outline-danger">حذف</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
        </div>

<?php
include "../../include/layout/footer.php"
?>